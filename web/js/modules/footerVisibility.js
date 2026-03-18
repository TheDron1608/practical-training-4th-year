const data = {
  minScroll: 50,
  currentScrollPosition: null,
  prevScrollPosition: null,
}

function changeFooterVisibility(footer, footerActive) {
  let footerHasIsAlreadyActive = footer.classList.contains(footerActive);
  if (window.pageYOffset < this.minScroll) {
    footer.classList.remove(footerActive);
  }
  this.currentScrollPosition = window.pageYOffset;
  if (this.currentScrollPosition > this.prevScrollPosition && !footerHasIsAlreadyActive) {
    footer.classList.add(footerActive);
  }
  if (this.currentScrollPosition < this.prevScrollPosition && footerHasIsAlreadyActive) {
    footer.classList.remove(footerActive);
  }
  this.prevScrollPosition = this.currentScrollPosition;
}

let changeFooter = changeFooterVisibility.bind(data);

export default changeFooter;