document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('bookForm');
    const tableBody = document.querySelector('#booksTable tbody');
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = document.getElementById('id').value;
        const data = new FormData(form);

        const action = id ? 'update' : 'create';
        const url = `crud.php?action=${action}`;

        if (id) {
            data.append('id', id);
        }

        fetch(url, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                loadBooks();
                form.reset();
                document.getElementById('id').value = '';
            } else {
                alert('Hubo un error al procesar la solicitud: ' + result.message);
            }
        });
    });

    tableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit')) {
            const row = e.target.closest('tr');
            document.getElementById('id').value = row.dataset.id;
            document.getElementById('titulo').value = row.querySelector('.titulo').innerText;
            document.getElementById('autor').value = row.querySelector('.autor').innerText;
            document.getElementById('editorial').value = row.querySelector('.editorial').innerText;
            document.getElementById('fechaPublicacion').value = row.querySelector('.fechaPublicacion').innerText;
            document.getElementById('numeroPaginas').value = row.querySelector('.numeroPaginas').innerText;
        } else if (e.target.classList.contains('delete')) {
            const id = e.target.closest('tr').dataset.id;
            fetch('crud.php?action=delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            }).then(response => response.json())
              .then(result => {
                  if (result.status === 'success') {
                      loadBooks();
                  } else {
                      alert('Hubo un error al eliminar el libro.');
                  }
              });
        }
    });

    function loadBooks() {
        fetch('crud.php?action=read')
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach(book => {
                    const row = document.createElement('tr');
                    row.dataset.id = book.id;
                    row.innerHTML = `
                        <td class="titulo">${book.titulo}</td>
                        <td class="autor">${book.autor}</td>
                        <td class="editorial">${book.editorial}</td>
                        <td class="fechaPublicacion">${book.fechaPublicacion}</td>
                        <td class="numeroPaginas">${book.numeroPaginas}</td>
                        <td class="actions">
                            <button class="edit">Editar</button>
                            <button class="delete">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    loadBooks();
});
