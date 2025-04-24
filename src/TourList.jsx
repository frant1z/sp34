import React from 'react'
import { Button } from './components/ui/button'
import { Card, CardContent } from './components/ui/card'

const tours = [
  {
    id: 1,
    title: "Золотое Кольцо России",
    description: "5 дней, автобусный тур по историческим городам.",
    image: "https://source.unsplash.com/featured/?russia,travel",
  },
  {
    id: 2,
    title: "Выходные в Казани",
    description: "3 дня с экскурсиями и гастрономическим туром.",
    image: "https://source.unsplash.com/featured/?kazan,city",
  },
  {
    id: 3,
    title: "Горы Кавказа",
    description: "7 дней активного отдыха с походами и экскурсиями.",
    image: "https://source.unsplash.com/featured/?caucasus,mountains",
  },
]

export default function TourList() {
  return (
    <div className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      {tours.map((tour) => (
        <Card key={tour.id} className="rounded-2xl shadow-md overflow-hidden">
          <img src={tour.image} alt={tour.title} className="h-48 w-full object-cover" />
          <CardContent className="p-4">
            <h2 className="text-xl font-semibold mb-2">{tour.title}</h2>
            <p className="text-sm text-gray-600 mb-4">{tour.description}</p>
            <Button>Подробнее</Button>
          </CardContent>
        </Card>
      ))}
    </div>
  )
}
