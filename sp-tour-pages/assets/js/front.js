document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('.sptp-acc-btn').forEach(function(btn){
        btn.addEventListener('click',function(){
            var panel=btn.nextElementSibling;
            panel.classList.toggle('open');
            btn.classList.toggle('open');
        });
    });
    var form=document.getElementById('sptp-form');
    if(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();
            var fd=new FormData(form);
            fd.append('action','sp_tour_send');
            fd.append('nonce',sptpAjax.nonce);
            fetch(sptpAjax.url,{method:'POST',body:fd}).then(r=>r.json()).then(function(){
                alert('Заявка отправлена');
                form.reset();
            });
        });
    }
    document.querySelectorAll('a[href^="#"]').forEach(function(a){
        a.addEventListener('click',function(e){
            var id=a.getAttribute('href');
            if(id.length>1&&document.querySelector(id)){
                e.preventDefault();
                document.querySelector(id).scrollIntoView({behavior:'smooth'});
            }
        });
    });
});
