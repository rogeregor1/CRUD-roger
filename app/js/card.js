
const cards = document.querySelectorAll('.cards__item');

function transition(e) {
  e.preventDefault();

  if (this.classList.contains('active')) {
    this.classList.remove('active')
  } else {
    this.classList.add('active');
  }
}

cards.forEach(card => card.addEventListener('click', transition));
 