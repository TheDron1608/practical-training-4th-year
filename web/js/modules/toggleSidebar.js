function sidebarToggleHandler(
  main,
  sidebar,
  backdrop,
  mainToggle,
  sidebarToggle,
  backdropToggle,
) {
  main.classList.toggle(mainToggle);
  sidebar.classList.toggle(sidebarToggle);
  backdrop.classList.toggle(backdropToggle);
  if (main.classList.contains(mainToggle)) {
    return body.style.overflow = 'hidden';
  }
  body.style.overflow = 'auto';
}

export default sidebarToggleHandler;