document.addEventListener('click', async function (e) {
  if (!e.target.closest('.grid-prev, .grid-next')) return;

  const button = e.target;
  const wrapper = button.closest('.project-grid-pagination');
  const gridContainer = wrapper.previousElementSibling;

  if (!wrapper || !gridContainer) return;

  const currentPage = parseInt(wrapper.dataset.page);
  const totalPages = parseInt(wrapper.dataset.total);
  const items = wrapper.dataset.items;
  const postType = wrapper.dataset.posttype;
  const category = wrapper.dataset.category;

  const nextPage = button.classList.contains('grid-next') ? currentPage + 1 : currentPage - 1;

  const params = new URLSearchParams({
    paged: nextPage,
    'attributes[itemsToShow]': items,
    'attributes[postType]': postType,
    'attributes[category]': category
  });

  try {
    const res = await fetch(window.location.pathname + '?' + params.toString());
    const html = await res.text();
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    const newGrid = doc.querySelector('.project-grid');
    const newPagination = doc.querySelector('.project-grid-pagination');

    if (newGrid && newPagination) {
      gridContainer.replaceWith(newGrid);
      wrapper.replaceWith(newPagination);
    }
  } catch (err) {
    console.error('Pagination error:', err);
  }
});
