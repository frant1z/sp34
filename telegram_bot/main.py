import os
import asyncio
from datetime import datetime, timedelta

from telegram import Update
from telegram.ext import (
    ApplicationBuilder,
    CommandHandler,
    ContextTypes,
    MessageHandler,
    filters,
)

import openai

openai.api_key = os.getenv("OPENAI_API_KEY")
BOT_TOKEN = os.getenv("TELEGRAM_BOT_TOKEN")

# In-memory storage for tasks and reminders
user_tasks = {}
reminders = []


async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    await update.message.reply_text(
        "Привет! Я ваш помощник с ИИ. Используйте /task, /tasks, /done и /remind."
    )


async def add_task(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    text = " ".join(context.args)
    if not text:
        await update.message.reply_text("Использование: /task <описание задачи>")
        return
    tasks = user_tasks.setdefault(update.effective_user.id, [])
    tasks.append({"text": text, "done": False})
    await update.message.reply_text(f"Задача добавлена: {text}")


async def list_tasks(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    tasks = user_tasks.get(update.effective_user.id, [])
    if not tasks:
        await update.message.reply_text("Нет задач")
        return
    lines = []
    for i, t in enumerate(tasks, 1):
        status = "✅" if t["done"] else "❌"
        lines.append(f"{i}. {t['text']} {status}")
    await update.message.reply_text("\n".join(lines))


async def done_task(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    tasks = user_tasks.get(update.effective_user.id, [])
    if not tasks:
        await update.message.reply_text("Нет задач")
        return
    try:
        idx = int(context.args[0]) - 1
    except (IndexError, ValueError):
        await update.message.reply_text("Использование: /done <номер задачи>")
        return
    if 0 <= idx < len(tasks):
        tasks[idx]["done"] = True
        await update.message.reply_text("Задача отмечена как выполненная")
    else:
        await update.message.reply_text("Неверный номер задачи")


async def remind(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if len(context.args) < 2:
        await update.message.reply_text("Использование: /remind <минуты> <текст>")
        return
    try:
        minutes = int(context.args[0])
    except ValueError:
        await update.message.reply_text("Минуты должны быть числом")
        return
    text = " ".join(context.args[1:])
    time_due = datetime.utcnow() + timedelta(minutes=minutes)
    reminders.append({"user": update.effective_user.id, "time": time_due, "text": text})
    await update.message.reply_text(f"Напоминание установлено через {minutes} минут")


async def check_reminders(context: ContextTypes.DEFAULT_TYPE) -> None:
    now = datetime.utcnow()
    due = [r for r in reminders if r["time"] <= now]
    for r in due:
        await context.bot.send_message(chat_id=r["user"], text=f"Напоминание: {r['text']}")
        reminders.remove(r)


async def ai_chat(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not openai.api_key:
        await update.message.reply_text("OpenAI API key не настроен")
        return
    history = context.user_data.setdefault("history", [])
    history.append({"role": "user", "content": update.message.text})
    if len(history) > 10:
        history = history[-10:]
        context.user_data["history"] = history
    try:
        resp = await openai.ChatCompletion.acreate(
            model="gpt-3.5-turbo",
            messages=history,
        )
        reply = resp["choices"][0]["message"]["content"].strip()
        history.append({"role": "assistant", "content": reply})
        await update.message.reply_text(reply)
    except Exception as e:
        await update.message.reply_text(f"Ошибка при обращении к ИИ: {e}")


async def main() -> None:
    if not BOT_TOKEN:
        raise RuntimeError("TELEGRAM_BOT_TOKEN не установлен")
    application = ApplicationBuilder().token(BOT_TOKEN).build()

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("task", add_task))
    application.add_handler(CommandHandler("tasks", list_tasks))
    application.add_handler(CommandHandler("done", done_task))
    application.add_handler(CommandHandler("remind", remind))
    application.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, ai_chat))

    application.job_queue.run_repeating(check_reminders, interval=30)

    await application.initialize()
    await application.start()
    await application.updater.start_polling()
    await application.updater.idle()


if __name__ == "__main__":
    asyncio.run(main())
