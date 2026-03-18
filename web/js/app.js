import changeFooterVisibility from './modules/footerVisibility.js';
import initSidebarNavigation from './modules/initSidebarNavigation.js';
import sidebarNestedListToggle from './modules/sidebarNestedListToggle.js';
import sidebarToggleHandler from './modules/toggleSidebar.js';

function getElementToggleClass() {
  return {
    sidebarToggle: 'sidebar__show',
    backdropToggle: 'backdrop-custom__show',
    mainToggle: 'app-content__blur',
    footerActive: 'footer__active',
  }
}

function getElements() {
  const main = document.getElementById('main');
  const sidebar = document.getElementById('sidebar');
  const toggleSidebar = document.getElementById('toggle-sidebar');
  const backdrop = document.getElementById('backdrop-custom');
  const footer = document.getElementById('footer');
  const theme = document.getElementById('theme');
  return {
    main,
    sidebar,
    footer,
    toggleSidebar,
    backdrop,
    theme,
  }
}

const { main, sidebar, toggleSidebar, backdrop, footer, theme } = getElements();
const { backdropToggle, mainToggle, sidebarToggle, footerActive } = getElementToggleClass();

function handleWindowScroll() {
  changeFooterVisibility(footer, footerActive);
}

function handleBackdropClick() {
  sidebarToggleHandler(
    main,
    sidebar,
    backdrop,
    mainToggle,
    sidebarToggle,
    backdropToggle,
  );
}

function handleSidebarToggle() {
  sidebarToggleHandler(
    main,
    sidebar,
    backdrop,
    mainToggle,
    sidebarToggle,
    backdropToggle,
  );
}

function createSunCircle() {
  const R = 13;
  const sun_light_size = 50;
  const sunItems = document.querySelectorAll('.theme-item');
  sunItems.forEach((item, i) => {
    let radian = i * (2 * Math.PI / sunItems.length) - 0.5 * Math.PI;
    let x = R * Math.cos(radian) - sun_light_size / 2;
    let y = R * Math.sin(radian) - sun_light_size / 2;
    item.style.left = x * -1 + "px";
    item.style.top = y * -1 + "px";
  })

}

function changeThemeListener(is_check_theme) {
  if (is_check_theme === true) {
    if (localStorage.getItem('theme') != 'is-dark') {
      return
    }
  }
  document.body.classList.toggle('dark');
  theme.classList.toggle('__is-light')
  localStorage.setItem('theme', theme.classList.contains('__is-light') ? null : 'is-dark');
}

(function init() {
  toggleSidebar.addEventListener('click', handleSidebarToggle);
  backdrop.addEventListener('click', handleBackdropClick);
  sidebar.addEventListener('click', sidebarNestedListToggle);
  theme.addEventListener('click', changeThemeListener);
  window.addEventListener("scroll", handleWindowScroll);
  initSidebarNavigation();
  createSunCircle();
  changeThemeListener(true);
})();