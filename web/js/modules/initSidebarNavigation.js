function initSidebarNavigation() {
  let linksList = sidebar.querySelectorAll('.actions-list__link');
  let href = String(window.location.href);
  linksList.forEach(link => {
    if (href.includes(link.getAttribute('href'))) {
      activateNestedList(link);
      link.closest('.actions-list__item').classList.add('__active');
    }
  })
}

function activateNestedList(link) {
  let list = link.closest('.__nested-list');
  if (list) {
    list.classList.add('__active');
    // let upList = list.closest('.__nested-list');
    // if (upList) {
    //   activateNestedList(upList);
    // }
  }
}

export default initSidebarNavigation;

// function initSidebarNavigation() {
//   const sidebarNav = [
//     {
//       title: 'Название списка',
//       content: [
//         {
//           title: 'Название элемента',
//           link: '#',
//         },
//         {
//           title: 'Название элемента',
//           link: '#',
//         },
//         {
//           title: 'Название элемента 123123123',
//           content: [
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//           ],
//           closed: true,
//         },
//       ],
//       closed: true,
//     },
//     {
//       title: 'Название списка',
//       link: '#',
//     },
//     {
//       title: 'Название списка',
//       content: [
//         {
//           title: 'Название элемента',
//           link: '#',
//         },
//         {
//           title: 'Название элемента',
//           link: '#',
//         },
//         {
//           title: 'Название элемента',
//           content: [
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//             {
//               title: 'Название элемента',
//               link: '#',
//             },
//           ],
//           closed: true,
//         },
//       ],
//     },
//   ];
//   const ul = document.createElement('ul');
//   ul.classList.add('actions-list');
//   sidebarNav.forEach(item => {
//     let li = document.createElement('li');
//     li.classList.add('actions-list__item')
//     if (!item.content) {
//       let link = getLinkInLiElement(item.link, item.title);
//       li.appendChild(link);
//       ul.appendChild(li);
//     } else {
//       createNestedList(ul, item);
//     }
//   })
//   sidebar.appendChild(ul);
// }

// function createNestedList(ul, list) {
//   if (ul && list.content.length) {
//     // Добавляем title блока
//     let liTitle = document.createElement('li');
//     liTitle.setAttribute('data-sidebardropdown', true);
//     liTitle.textContent = list.title
//     liTitle.classList.add('actions-list__title', 'actions-list__title-nested');

//     // Добаляем список для контента
//     let contentUlForContent = document.createElement('ul')
//     contentUlForContent.classList.add('actions-list__sublist', '__nested-list');

//     // Заполняем список контентом
//     list.content.forEach(item => {
//       let li = document.createElement('li');
//       li.classList.add('actions-list__item', 'actions-list__sublist-item');
//       if (list.closed) {
//         contentUlForContent.style.display = 'none';
//       }
//       if (!item.content) {
//         let link = getLinkInLiElement(item.link, item.title);
//         li.appendChild(link);
//         contentUlForContent.appendChild(li);
//       } else {
//         createNestedList(contentUlForContent, item)
//       }
//     })

//     ul.appendChild(liTitle);
//     ul.appendChild(contentUlForContent);
//   }
// }

// function getLinkInLiElement(link, title) {
//   let linkEl = document.createElement('a');
//   linkEl.classList.add('actions-list__link');
//   linkEl.textContent = title;
//   linkEl.setAttribute('href', link);
//   return linkEl;
// }