
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('studentForm');
    const tableBody = document.querySelector('#studentsTable tbody');
    
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
                loadStudents();
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
            document.getElementById('codigo').value = row.querySelector('.codigo').innerText;
            document.getElementById('nombre').value = row.querySelector('.nombre').innerText;
            document.getElementById('apellidoPaterno').value = row.querySelector('.apellidoPaterno').innerText;
            document.getElementById('apellidoMaterno').value = row.querySelector('.apellidoMaterno').innerText;
            document.getElementById('dni').value = row.querySelector('.dni').innerText;
            document.getElementById('facultad').value = row.querySelector('.facultad').innerText;
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
                      loadStudents();
                  } else {
                      alert('Hubo un error al eliminar el estudiante.');
                  }
              });
        }
    });

    function loadStudents() {
        fetch('crud.php?action=read')
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach(student => {
                    const row = document.createElement('tr');
                    row.dataset.id = student.id;
                    row.innerHTML = `
                        <td class="codigo">${student.codigo}</td>
                        <td class="nombre">${student.nombre}</td>
                        <td class="apellidoPaterno">${student.apellidoPaterno}</td>
                        <td class="apellidoMaterno">${student.apellidoMaterno}</td>
                        <td class="dni">${student.DNI}</td>
                        <td class="facultad">${student.facultad}</td>
                        <td class="actions">
                            <button class="edit">Editar</button>
                            <button class="delete">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    loadStudents();
});