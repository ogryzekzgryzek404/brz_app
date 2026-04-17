<?php
session_start();
require 'db.php';

if (!isset($_SESSION['ids'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['ids'];

$stmt = $pdo->prepare("
    SELECT u.*, uz.nazwa_urzedu 
    FROM brz_uzytkownicy u
    LEFT JOIN brz_urzedy uz ON uz.ids = u.ids_urzedu
    WHERE u.ids = :id
");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$idUrzedu = $user['ids_urzedu'];

$catStmt = $pdo->query("SELECT ids, kategoria FROM brz_kategorie ORDER BY kategoria");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Centralny Rejestr Rzeczy Znalezionych</title>
<meta name="viewport" content="width=device-width,initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root {
    --navy: #0a2342;
    --navy-light: #10376a;
    --contrast-text: #ffffff;
    --focus-color: #ffcc00;
}

body {
    background: #e9f2fb;
    font-family: Arial, sans-serif;
}

.sidebar {
    width: 240px;
    height: 100vh;
    background: var(--navy);
    color: var(--contrast-text);
    position: fixed;
    padding-top: 20px;
}

.sidebar a {
    color: #eef5ff;
    padding: 12px 18px;
    display: block;
    text-decoration: none;
    font-weight: 500;
}

.sidebar a:focus,
.sidebar a:hover {
    background: var(--navy-light);
    outline: 3px solid var(--focus-color);
    outline-offset: 2px;
}

@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    .content {
        margin-left: 0 !important;
        padding-top: 160px !important;
    }
    .topbar {
        left: 0 !important;
    }
}

.topbar {
    position: fixed;
    left: 240px;
    right: 0;
    top: 0;
    background: #ffffff;
    border-bottom: 2px solid #d0e2ff;
    padding: 12px 20px;
    z-index: 1000;
}
@media (max-width:768px){
    .topbar {
        position: static;   /* no sticky/fixed */
        z-index: auto;
    }
}

.content {
    margin-left: 240px;
    padding: 90px 20px 20px 20px;
}

main:focus {
    outline: 3px solid var(--focus-color);
}

.table-wrap {
    background: #fff;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    overflow-x: auto; /* MOBILE FIX */
    max-height: 70vh;
}

table thead th {
    background: var(--navy) !important;
    color: white !important;
}

tbody tr:hover:not(.selected) {
    background: #c4ddff !important;
}
tbody tr.selected {
    background: #a8d4ff !important;
    border: 2px solid #5fa9ff !important;
}
tbody tr.selected:focus {
    outline: 3px solid var(--focus-color);
}

.table td.textcell {
    max-width: 220px;
    white-space: normal !important;
    word-wrap: break-word;
}

tr:focus {
    outline: 3px solid var(--focus-color);
}

.modal[aria-modal="true"] {
    outline: none;
	
	
}

</style>
</head>
<body>

<nav class="sidebar" aria-label="Główne menu">
    <div class="text-center mb-3">
        <h5 class="mb-0">Menu</h5>
    </div>

    <a href="dashboard.php">Przeglądaj rejestr</a>
    <a href="#" id="menu-dodaj">Dodaj nową rzecz</a>
    <a href="#" id="btn-gen-year">Generuj plik dla roku</a>
    <a href="generuj.php" target="_blank">Eksport całości</a>
</nav>

<header class="topbar d-flex justify-content-between align-items-center" role="banner">
    <div class="fw-bold fs-5">Centralny Rejestr Rzeczy Znalezionych</div>

    <div class="d-flex align-items-center gap-4">
        <div class="d-flex flex-column text-end">
            <span class="fw-semibold">Zalogowany: <?= htmlspecialchars($user['imie_i_nazwisko']) ?></span>
            <span class="text-secondary"><?= htmlspecialchars($user['nazwa_urzedu']) ?></span>
        </div>

        <a href="logout.php" class="btn btn-sm btn-danger" aria-label="Wyloguj">Wyloguj</a>
    </div>
</header>

<main class="content" role="main" tabindex="-1">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h4 class="mb-2">Rejestr rzeczy znalezionych</h4>
        <div class="d-flex flex-wrap gap-2">
            <button id="btn-add" class="btn btn-success">Dodaj</button>
            <button id="btn-edit" class="btn btn-warning" disabled>Edytuj</button>
            <button id="btn-delete" class="btn btn-danger" disabled>Usuń</button>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
        <label class="fw-semibold" for="filter-year">Rok:</label>
        <select id="filter-year" class="form-select" style="width:120px;" aria-label="Filtr roku"></select>
    </div>

    <div class="table-wrap">
        <table class="table table-hover mb-0" id="rejestr-table" aria-describedby="table-info">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Data znalezienia</th>
                    <th scope="col">Miejsce znalezienia</th>
                    <th scope="col">Rodzaj</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Znak sprawy</th>
                    <th scope="col">Termin odbioru</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <p id="table-info" class="visually-hidden">
            Tabela rejestru rzeczy znalezionych. Można używać klawiszy strzałek do nawigacji.
        </p>
    </div>

</main>

<div class="modal fade" id="modalForm" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg">
    <form id="formRecord" class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Dodaj rekord</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
      </div>

      <div class="modal-body">

          <input type="hidden" name="action" id="form-action" value="add">
          <input type="hidden" name="ids" id="form-ids">

          <div class="row g-3">

              <div class="col-md-6">
                  <label class="form-label" for="data_znalezienia">Data znalezienia <span aria-hidden="true">*</span></label>
                  <input type="date" class="form-control" name="data_znalezienia" id="data_znalezienia" required>
              </div>

              <div class="col-md-6">
                  <label class="form-label" for="miejsce_znalezienia">Miejsce znalezienia</label>
                  <input type="text" class="form-control" name="miejsce_znalezienia" id="miejsce_znalezienia" required>
              </div>

              <div class="col-md-6">
                  <label class="form-label" for="termin_odbioru">Termin odbioru</label>
                  <input type="date" class="form-control" name="termin_odbioru" id="termin_odbioru" required>
              </div>

              <div class="col-md-6">
                  <label class="form-label" for="rodzaj_rzeczy">Rodzaj rzeczy</label>
                  <select class="form-select" name="rodzaj_rzeczy" id="rodzaj_rzeczy" required>
                    <option value="">-- wybierz --</option>
                    <?php foreach($categories as $c): ?>
                      <option value="<?=htmlspecialchars($c['ids'])?>"><?=htmlspecialchars($c['kategoria'])?></option>
                    <?php endforeach; ?>
                  </select>
              </div>

              <div class="col-md-6">
                  <label class="form-label" for="znak_sprawy">Znak sprawy</label>
                  <input type="text" class="form-control" name="znak_sprawy" id="znak_sprawy">
              </div>

              <div class="col-12">
                  <label class="form-label" for="opis_rzeczy">Opis</label>
                  <textarea class="form-control" id="opis_rzeczy" name="opis_rzeczy" rows="4"></textarea>
              </div>

              <div class="col-md-6">
                  <label class="form-label" for="numer_seryjny">Numer seryjny</label>
                  <input type="text" class="form-control" id="numer_seryjny" name="numer_seryjny">
              </div>

              <div class="col-md-6 d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="OZ" name="OZ">
                  <label class="form-check-label" for="OZ">Przekazane (OZ)</label>
              </div>

          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
        <button type="submit" class="btn btn-primary">Zapisz</button>
      </div>
    </form>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <form id="formDelete" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Potwierdź usunięcie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="ids" id="delete-ids">
        Czy na pewno chcesz usunąć rekord?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
        <button type="submit" class="btn btn-danger">Usuń</button>
      </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

const idUrzedu = <?= json_encode((int)$idUrzedu) ?>;
let selectedId = null;

const modalForm = new bootstrap.Modal(document.getElementById('modalForm'));
const modalDelete = new bootstrap.Modal(document.getElementById('modalDelete'));

document.addEventListener('DOMContentLoaded', async () => {

    await loadYears();
    loadTable();

    document.getElementById('btn-add').addEventListener('click', openAdd);
    document.getElementById('menu-dodaj').addEventListener('click', e => { e.preventDefault(); openAdd(); });

    document.getElementById('btn-edit').addEventListener('click', openEdit);
    document.getElementById('btn-delete').addEventListener('click', openDelete);

    document.getElementById('formRecord').addEventListener('submit', saveRecord);
    document.getElementById('formDelete').addEventListener('submit', deleteRecord);

    document.getElementById('filter-year').addEventListener('change', loadTable);

    document.getElementById('btn-gen-year').addEventListener('click', () => {
        const year = document.getElementById('filter-year').value || new Date().getFullYear();
        window.open('generuj_rok.php?rok='+encodeURIComponent(year), '_blank');
    });

});

function loadYears() {
    return fetch('api_rejestr.php?action=years')
    .then(r=>r.json())
    .then(years=>{
        const sel = document.getElementById('filter-year');
        sel.innerHTML = '';
        const current = new Date().getFullYear();

        years.forEach(y=>{
            sel.innerHTML += `<option value="${y}">${y}</option>`;
        });

        if (years.includes(current)) sel.value = current;
        else if (years.length>0) sel.value = years[0];
    });
}

function loadTable(){
    const year = document.getElementById('filter-year').value || 0;

    fetch('api_rejestr.php?action=list&id_urzedu='+idUrzedu+'&year='+year)
    .then(r=>r.json())
    .then(data=>{
        const tbody = document.querySelector('#rejestr-table tbody');
        tbody.innerHTML = '';
        selectedId = null;

        document.getElementById('btn-edit').disabled = true;
        document.getElementById('btn-delete').disabled = true;

        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.dataset.id = row.ids;
            tr.tabIndex = 0;

            tr.innerHTML = `
                <td>${row.ids}</td>
                <td>${row.data_znalezienia}</td>
                <td class="textcell">${escapeHtml(row.miejsce_znalezienia)}</td>
                <td class="textcell">${escapeHtml(row.kategoria ?? '')}</td>
                <td class="textcell">${escapeHtml(row.opis_rzeczy)}</td>
                <td class="textcell">${escapeHtml(row.znak_sprawy ?? '')}</td>
                <td>${row.termin_odbioru ?? ''}</td>
            `;

            tr.onclick = () => selectRow(tr);
            tr.onkeydown = handleRowKeyboard;

            tbody.appendChild(tr);
        });
    });
}

function handleRowKeyboard(e){
    const rows = Array.from(document.querySelectorAll('#rejestr-table tbody tr'));
    const index = rows.indexOf(e.target);

    if (e.key === "ArrowDown") {
        if (rows[index+1]) rows[index+1].focus();
    }
    if (e.key === "ArrowUp") {
        if (rows[index-1]) rows[index-1].focus();
    }
    if (e.key === "Enter") {
        selectRow(e.target);
    }
    if (e.key === "Escape") {
        document.querySelectorAll('#rejestr-table tbody tr').forEach(r=>r.classList.remove('selected'));
        selectedId = null;
        document.getElementById('btn-edit').disabled = true;
        document.getElementById('btn-delete').disabled = true;
    }
}

function selectRow(tr){
    document.querySelectorAll('#rejestr-table tbody tr')
        .forEach(r => r.classList.remove('selected'));

    tr.classList.add('selected');
    selectedId = tr.dataset.id;

    document.getElementById('btn-edit').disabled = false;
    document.getElementById('btn-delete').disabled = false;
}

function openAdd(){
    document.getElementById('form-action').value = 'add';
    document.getElementById('modalTitle').textContent = 'Dodaj rekord';
    clearFormFields();
    modalForm.show();
}

function openEdit(){
    if (!selectedId) return;

    fetch('api_rejestr.php?action=get&ids=' + selectedId)
    .then(r => r.json())
    .then(row => {

        document.getElementById('form-action').value = 'edit';
        document.getElementById('modalTitle').textContent = 'Edytuj rekord #' + row.ids;
        document.getElementById('form-ids').value = row.ids;

        document.getElementById('data_znalezienia').value = row.data_znalezienia.substring(0,10);
        document.getElementById('miejsce_znalezienia').value = row.miejsce_znalezienia || '';
        document.getElementById('termin_odbioru').value = row.termin_odbioru ? row.termin_odbioru.substring(0,10) : '';
        document.getElementById('rodzaj_rzeczy').value = row.rodzaj_rzeczy || '';
        document.getElementById('opis_rzeczy').value = row.opis_rzeczy || '';
        document.getElementById('numer_seryjny').value = row.numer_seryjny || '';
        document.getElementById('znak_sprawy').value = row.znak_sprawy || '';
        document.getElementById('OZ').checked = row.OZ == 1;

        modalForm.show();
    });
}


function openDelete(){
    if (!selectedId) return;
    document.getElementById('delete-ids').value = selectedId;
    modalDelete.show();
}

function saveRecord(e){
    e.preventDefault();
    const fd = new FormData(e.target);
    fd.append('id_urzedu', idUrzedu);

    fetch('api_rejestr.php',{ method:'POST', body:fd })
    .then(r=>r.json())
    .then(res=>{
        if (res.success) {
            modalForm.hide();
            loadTable();
        } else alert("Błąd: "+res.error);
    });
}

function deleteRecord(e){
    e.preventDefault();
    const fd = new FormData(e.target);

    fetch('api_rejestr.php',{ method:'POST', body:fd })
    .then(r=>r.json())
    .then(res=>{
        if (res.success) {
            modalDelete.hide();
            loadTable();
        } else alert("Błąd: "+res.error);
    });
}

function escapeHtml(s){
    return (''+s).replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('&','&amp;');
}

function clearFormFields(){
    document.getElementById('data_znalezienia').value='';
    document.getElementById('miejsce_znalezienia').value='';
    document.getElementById('rodzaj_rzeczy').value='';
    document.getElementById('opis_rzeczy').value='';
    document.getElementById('numer_seryjny').value='';
    document.getElementById('znak_sprawy').value='';
    document.getElementById('termin_odbioru').value='';
    document.getElementById('OZ').checked=false;
}

</script>

</body>
</html>
