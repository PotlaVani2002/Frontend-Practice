window.addEventListener('resize', function() {
    const myDiv = document.getElementById('mobile');
    const myClose=this.document.getElementById('close')
    if (window.innerWidth <= 799) {
        myDiv.style.display = 'block';
        myClose.style.display='block';
    } else {
        myDiv.style.display = 'none';
        myClose.style.display = 'none';
    }
});

window.dispatchEvent(new Event('resize'));

const bar=document.getElementById('bar');
const close=document.getElementById('close');
const nav=document.getElementById('navbar');
if(bar){
    bar.addEventListener('click',()=>{
        nav.classList.add('active');
    })
}
if(close){
    close.addEventListener('click',()=>{
        nav.classList.remove('active');
    })
}