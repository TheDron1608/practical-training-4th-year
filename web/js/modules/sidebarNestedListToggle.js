function sidebarNestedListToggle(e) {
  let item = e.target;
  let closestParent = e.target.closest('.actions-list__title-nested');
  let isParent = closestParent?.dataset?.sidebardropdown;

  if (item.dataset.sidebardropdown || isParent) {
    let list = null;
    if (isParent) {
      list = closestParent.nextSibling.nextSibling;
    } else {
      list = e.target.nextSibling.nextSibling;
    }
    list.classList.toggle('__active');
  }
}

export default sidebarNestedListToggle;