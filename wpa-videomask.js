function lf(e){var i=d.createElement("iframe");i.setAttribute("src","https://youtube.com/embed/"+e.dataset.videoId+"?&rel=0"),i.setAttribute("frameborder","0"),i.setAttribute("allowfullscreen","1"),i.setAttribute("allow","accelerometer; autoplay; encrypted-media;gyroscope;picture-in-picture"),e.parentNode.classList.remove('passive'),e.parentNode.replaceChild(i,e)}d=document,d.addEventListener("DOMContentLoaded",function(){d.querySelectorAll("div[data-video-src]").forEach(function(e,_){e.classList.add("mask"),e.parentNode.classList.add('passive'),vs=e.dataset.videoSrc.split("/"),id=vs[vs.length-1].replace("watch?v=",''),e.dataset.videoId=id,e.parentNode.dataset.srcBackground="https://i.ytimg.com/vi/"+id+"/hqdefault.jpg",e.style.zIndex=2,e.onmouseover=e.onclick=function(){lf(this)},io=new IntersectionObserver(function(a){a.forEach(a=>{if(a.isIntersecting){var o=a.target;is=o.dataset.srcBackground||'',o.style.backgroundImage='url("'+is+'")',ul(o)}})},{root:null,rootMargin:window.innerHeight+"px",threshold:0.5}),ul=function(a){a.classList.remove('lazy'),io.unobserve(a),a.dataset.srcBackground&&delete a.dataset.srcBackground},d.querySelectorAll(".lazy.videomask").forEach(a=>io.observe(a))})});