(function(){
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('sptp-upload')){
            e.preventDefault();
            var btn = e.target;
            var frame = wp.media({title:'Выбор изображения', multiple:true});
            frame.on('select', function(){
                var atts = frame.state().get('selection').toJSON();
                var items = btn.closest('.sptp-images').querySelectorAll('.sptp-img-item');
                atts.forEach(function(att,idx){
                    if(idx < items.length){
                        var input = items[idx].querySelector('input');
                        var img   = items[idx].querySelector('img');
                        input.value = att.id;
                        img.src = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                    }
                });
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
            var frame=wp.media({title:'Галерея', multiple:true});
            frame.on('select',function(){
                frame.state().get('selection').toJSON().forEach(function(att){
                    var div=document.createElement('div');
                    div.className='sptp-gallery-item';
                    div.innerHTML='<input type="hidden" name="sp_gallery[]" value="'+att.id+'" /> <img src="'+(att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url)+'" /> <button class="sptp-remove">Удалить</button>';
                    wrap.appendChild(div);
                });
            });
            frame.open();
        }
        if(e.target.classList.contains('sptp-remove')){
            e.preventDefault();
            e.target.parentNode.remove();
        }
    });
})();
