
function criarCampoCPF() {
    const Permissao = parseInt(document.getElementById('nivel').value);
    const div = document.getElementById('cpf');
    const cpfValue = div.getAttribute('data-cpf');

    div.innerHTML = '';

    if (Permissao === 0) {
        const label = document.createElement('label');
        label.textContent = 'CPF:';
        label.setAttribute('for', 'cpf');

        const input = document.createElement('input');
        input.type = 'text';
        input.id = 'cpf';
        input.name = 'cpf';
        input.value = cpfValue;

        div.appendChild(label);
        div.appendChild(input);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    criarCampoCPF();
});

document.getElementById('nivel').addEventListener('change', criarCampoCPF);