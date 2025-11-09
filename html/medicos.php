<?php
$pageTitle = 'Médicos';
$currentPage = 'medicos';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Cadastre e gerencie médicos';
$pageStyles = ['medicos.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Lista de Médicos</h2>
                <p>Total de 23 médicos ativos</p>
            </div>
            <a href="cadastroMedico.html" class="btn-primary new-item-btn">
                <i class="fas fa-user-plus"></i> Novo Médico
            </a>
        </div>
        
        <div class="data-section">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por nome, CRM ou especialidade...">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CRM</th>
                            <th>ESPECIALIDADE</th>
                            <th>TELEFONE</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="main-info">Dr. João Santos</td>
                            <td>CRM/SP 123456</td>
                            <td>Cardiologia</td>
                            <td>(11) 98765-4321</td>
                            <td><span class="status-badge ativo">Ativo</span></td>
                             <td class="actions">
                                <a href="atualizarMedico.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarMedico.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="main-info">Dra. Ana Lima</td>
                            <td>CRM/RJ 654321</td>
                            <td>Dermatologia</td>
                            <td>(21) 99876-5432</td>
                            <td><span class="status-badge ativo">Ativo</span></td>
                           <td class="actions">
                                <a href="atualizarMedico.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarMedico.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="main-info">Dr. Carlos Rocha</td>
                            <td>CRM/MG 456789</td>
                            <td>Neurologia</td>
                            <td>(31) 97654-3210</td>
                            <td><span class="status-badge inativo">Inativo</span></td>
                          <td class="actions">
                                <a href="atualizarMedico.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarMedico.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>