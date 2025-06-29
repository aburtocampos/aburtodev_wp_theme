document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('.search-form');
    const postsContainer = document.querySelector('#posts-container');
    const pagination = document.querySelector('#pagination');

      if (!postsContainer) return;

    function renderPagination(current, total) {
    const pagination = document.querySelector('#pagination');
    pagination.innerHTML = '';

    const createButton = (text, page, disabled = false) => {
        const btn = document.createElement('button');
        btn.textContent = text;
        btn.dataset.page = page;
        btn.classList.add('page-btn');
        if (disabled) btn.disabled = true;
        return btn;
    };

    // Prev button
    pagination.appendChild(createButton('« Prev', current - 1, current === 1));

    // First page
    if (current > 2) {
        pagination.appendChild(createButton('1', 1));
        if (current > 3) {
            const dots = document.createElement('span');
            dots.textContent = '…';
            dots.classList.add('pagination-dots');
            pagination.appendChild(dots);
        }
    }

    // Middle pages
    for (let i = current - 1; i <= current + 1; i++) {
        if (i > 1 && i < total) {
            const btn = createButton(i, i, i === current);
            pagination.appendChild(btn);
        }
    }

    // Last page
    if (current < total - 1) {
        if (current < total - 2) {
            const dots = document.createElement('span');
            dots.textContent = '…';
            dots.classList.add('pagination-dots');
            pagination.appendChild(dots);
        }
        pagination.appendChild(createButton(total, total));
    }

    // Next button
    pagination.appendChild(createButton('Next »', current + 1, current === total));
}


   const fetchPosts = (paged = 1, search = '') => {
    const data = new URLSearchParams();
    data.append('action', 'glint_get_posts'); 
    data.append('paged', paged);
    data.append('search', search);

    fetch(glint_ajax.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
    })
    .then(res => {
        const postsContainer = document.querySelector('#posts-container');
        const pagination = document.querySelector('#pagination');

        postsContainer.innerHTML = res.html;
        pagination.innerHTML = '';

       renderPagination(paged, res.max_pages);
    })
    .catch(err => console.error('AJAX error:', err));
};


    // search form

    if (form) {
    const input = form.querySelector('.search-field');
    let debounceTimer;

    input.addEventListener('input', e => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            fetchPosts(1, e.target.value);
        }, 300); // 300ms delay after typing stops
    });
}

    // pagination
    pagination?.addEventListener('click', e => {
        if (e.target.classList.contains('page-btn')) {
            const page = parseInt(e.target.dataset.page);
            const term = form.querySelector('.search-field').value;
            fetchPosts(page, term);
        }
    });

    // Initial load if needed
    fetchPosts();
});
