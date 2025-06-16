(function(){
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('sptp-upload')){
            e.preventDefault();
            var btn = e.target;
            var frame = wp.media({title:'Выбор изображения', multiple:false});
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                btn.previousElementSibling.value = att.id;
                btn.previousElementSibling.previousElementSibling.src = att.sizes.thumbnail.url;
            });
            frame.open();
        }
        if(e.target.classList.contains('sptp-add-program')){
            e.preventDefault();
            var wrap = document.querySelector('.sptp-program');
            var div = document.createElement('div');
            div.className='sptp-program-item';
            div.innerHTML='<textarea name="sp_program[]" rows="2" style="width:100%;"></textarea> <button class="sptp-remove">Удалить</button>';
            wrap.appendChild(div);
        }
        if(e.target.classList.contains('sptp-add-date')){
            e.preventDefault();
            var wrap=document.querySelector('.sptp-dates');
            var div=document.createElement('div');
            div.className='sptp-date-item';
            div.innerHTML='<input type="date" name="sp_dates[][date]" /> <input type="text" name="sp_dates[][price]" placeholder="Цена" /> <label><input type="checkbox" name="sp_dates[][hot]" />🔥</label> <button class="sptp-remove">Удалить</button>';
            wrap.appendChild(div);
        }
        if(e.target.classList.contains('sptp-add-gallery')){
            e.preventDefault();
            var wrap=document.querySelector('.sptp-gallery');
            var div=document.createElement('div');
            div.className='sptp-gallery-item';
            var frame=wp.media({title:'Галерея', multiple:false});
            frame.on('select',function(){
                var att=frame.state().get('selection').first().toJSON();
                div.innerHTML='<input type="hidden" name="sp_gallery[]" value="'+att.id+'" /> <img src="'+att.sizes.thumbnail.url+'" /> <button class="sptp-remove">Удалить</button>';
                wrap.appendChild(div);
            });
            frame.open();
        }
        if(e.target.classList.contains('sptp-remove')){
            e.preventDefault();
            e.target.parentNode.remove();
        }
    });
})();
