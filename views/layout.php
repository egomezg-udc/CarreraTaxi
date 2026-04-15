<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarreraTaxi - CRUDL</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #333; }

        header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: white; padding: 1.2rem 2rem; display: flex;
            align-items: center; gap: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        header h1 { font-size: 1.6rem; }
        header span { font-size: 2rem; }

        nav { background: #0f3460; padding: 0.5rem 2rem; display: flex; gap: 1rem; }
        nav a {
            color: #e0e0e0; text-decoration: none; padding: 0.4rem 1rem;
            border-radius: 6px; font-size: 0.9rem; transition: background 0.2s;
        }
        nav a:hover, nav a.active { background: #e94560; color: white; }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }

        .alert-error {
            background: #ffe0e0; border-left: 4px solid #e94560;
            padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; color: #c0392b;
        }

        /* ---- TABLE ---- */
        .card { background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { background: #1a1a2e; color: white; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .card-header h2 { font-size: 1.1rem; }
        .btn-new { background: #e94560; color: white; padding: 0.5rem 1.2rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; transition: opacity 0.2s; }
        .btn-new:hover { opacity: 0.85; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #f7f8fc; padding: 0.8rem 1rem; text-align: left; font-size: 0.82rem; color: #666; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #eee; }
        td { padding: 0.8rem 1rem; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; }
        tr:hover td { background: #fafbff; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-green { background: #dcfce7; color: #166534; }

        .action-btns { display: flex; gap: 0.5rem; }
        .btn-edit { background: #3b82f6; color: white; padding: 0.3rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem; }
        .btn-delete { background: #ef4444; color: white; padding: 0.3rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem; }
        .btn-edit:hover { background: #2563eb; }
        .btn-delete:hover { background: #dc2626; }
        .empty { text-align: center; padding: 3rem; color: #999; }

        /* ---- FORM ---- */
        .form-card { background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem; }
        .form-card h2 { font-size: 1.2rem; margin-bottom: 1.5rem; color: #1a1a2e; border-bottom: 2px solid #e94560; padding-bottom: 0.5rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 0.85rem; font-weight: 600; color: #555; }
        input { padding: 0.6rem 0.8rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; transition: border-color 0.2s; }
        input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-actions { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-submit { background: #1a1a2e; color: white; padding: 0.7rem 1.8rem; border: none; border-radius: 6px; font-size: 0.95rem; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background: #0f3460; }
        .btn-cancel { background: #f0f0f0; color: #333; padding: 0.7rem 1.8rem; border: none; border-radius: 6px; font-size: 0.95rem; cursor: pointer; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

<header>
    <span>🚕</span>
    <h1>Sistema de Carreras de Taxi</h1>
</header>

<nav>
    <a href="index.php?action=list" class="<?= $action==='list'?'active':'' ?>">📋 Listar Carreras</a>
    <a href="index.php?action=create" class="<?= $action==='create'?'active':'' ?>">➕ Nueva Carrera</a>
</nav>

<div class="container">

    <?php if ($error): ?>
        <div class="alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
        <div class="card">
            <div class="card-header">
                <h2>Listado de Carreras (<?= count($carreras) ?>)</h2>
                <a href="index.php?action=create" class="btn-new">+ Nueva Carrera</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Taxi</th>
                        <th>Taxista</th>
                        <th>Origen → Destino</th>
                        <th>Km</th>
                        <th>Pasajeros</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($carreras)): ?>
                        <tr><td colspan="10" class="empty">No hay carreras registradas aún.</td></tr>
                    <?php else: ?>
                        <?php foreach ($carreras as $c): ?>
                        <tr>
                            <td><?= $c->getId() ?></td>
                            <td><?= htmlspecialchars($c->getCliente()) ?></td>
                            <td><span class="badge badge-blue"><?= htmlspecialchars($c->getTaxi()) ?></span></td>
                            <td><?= htmlspecialchars($c->getTaxista()) ?></td>
                            <td><?= htmlspecialchars($c->getBarrioInicio()) ?> → <?= htmlspecialchars($c->getBarrioLlegada()) ?></td>
                            <td><?= number_format($c->getKilometros(), 1) ?> km</td>
                            <td><?= $c->getCantidadPasajeros() ?></td>
                            <td><?= $c->getDuracionMinutos() ?> min</td>
                            <td><span class="badge badge-green">$<?= number_format($c->getPrecio(), 2) ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?action=edit&id=<?= $c->getId() ?>" class="btn-edit">✏️</a>
                                    <a href="index.php?action=delete&id=<?= $c->getId() ?>" class="btn-delete"
                                       onclick="return confirm('¿Eliminar esta carrera?')">🗑️</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php elseif ($action === 'create'): ?>
        <div class="form-card">
            <h2>➕ Registrar Nueva Carrera</h2>
            <form method="POST" action="index.php?action=create">
                <?php require __DIR__ . '/views/form_fields.php'; ?>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar Carrera</button>
                    <a href="index.php?action=list" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>

    <?php elseif ($action === 'edit' && $carreraParaEditar): ?>
        <div class="form-card">
            <h2>✏️ Editar Carrera #<?= $carreraParaEditar->getId() ?></h2>
            <form method="POST" action="index.php?action=update">
                <input type="hidden" name="id" value="<?= $carreraParaEditar->getId() ?>">
                <?php require __DIR__ . '/views/form_fields.php'; ?>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Actualizar Carrera</button>
                    <a href="index.php?action=list" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
