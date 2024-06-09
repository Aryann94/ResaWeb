let path = document.querySelector('path');
let pathLength = path.getTotalLength();

path.style.strokeDasharray = pathLength + ' ' + pathLength;

path.style.strokeDashoffset = pathLength;

window.addEventListener('scroll', () => {
  var scrollPercentage = (document.documentElement.scrollTop + document.body.scrollTop) / (document.documentElement.scrollHeight - document.documentElement.clientHeight);
  var drawLength = pathLength * scrollPercentage;
  path.style.strokeDashoffset = pathLength - drawLength;
});

window.addEventListener('scroll', () => {
  const target = document.querySelectorAll('.scroll');

  for (let index = 0; index < target.length; index++) {
    const pos = window.scrollY * target[index].dataset.rate;

    if(target[index].dataset.direction === 'vertical') {
      target[index].style.transform = 'translate3d(0px, ' + pos + 'px, 0px)';
    } else {
      const posX = window.scrollY * target[index].dataset.ratex;
      const posY = window.scrollY * target[index].dataset.ratey;

      target[index].style.transform = 'translate3d(' + posX + 'px, ' + posY + 'px, 0px)';
    }
  }
});