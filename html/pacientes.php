<?php
$pageTitle = 'Pacientes';
$currentPage = 'pacientes';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Gerencie informações dos pacientes';
$pageStyles = ['pacientes.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Lista de Pacientes</h2>
                <p>Total de 1,247 pacientes registrados</p>
            </div>
            <a href="cadastroPaciente.html" class="btn-primary new-item-btn">
                <i class="fas fa-user-plus"></i> Novo Paciente
            </a>
        </div>
        
        <div class="data-section">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por nome, CPF ou telefone...">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>DATA NASC.</th>
                            <th>TELEFONE</th>
                            <th>ÚLTIMA CONSULTA</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="main-info">Maria Silva Santos</td>
                            <td>123.456.789-00</td>
                            <td>10/05/1985</td>
                            <td>(11) 98765-4321</td>
                            <td>15/09/2024</td>
                            <td class="actions">
                                <a href="atualizarPaciente.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarPaciente.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="main-info">João Pedro Costa</td>
                            <td>987.654.321-11</td>
                            <td>03/12/2000</td>
                            <td>(21) 99876-5432</td>
                            <td>20/08/2024</td>
                           <td class="actions">
                                <a href="atualizarPaciente.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarPaciente.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="main-info">Ana Oliveira</td>
                            <td>456.789.012-22</td>
                            <td>25/01/1992</td>
                            <td>(31) 97654-3210</td>
                            <td>01/10/2024</td>
                             <td class="actions">
                                <a href="atualizarPaciente.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarPaciente.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>