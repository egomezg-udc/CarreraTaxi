<?php
// Precarga valores si estamos editando
$v = isset($carreraParaEditar) && $carreraParaEditar ? [
    'cliente'           => $carreraParaEditar->getCliente(),
    'taxi'              => $carreraParaEditar->getTaxi(),
    'kilometros'        => $carreraParaEditar->getKilometros(),
    'barrioInicio'      => $carreraParaEditar->getBarrioInicio(),
    'barrioLlegada'     => $carreraParaEditar->getBarrioLlegada(),
    'cantidadPasajeros' => $carreraParaEditar->getCantidadPasajeros(),
    'taxista'           => $carreraParaEditar->getTaxista(),
    'precio'            => $carreraParaEditar->getPrecio(),
    'duracionMinutos'   => $carreraParaEditar->getDuracionMinutos(),
] : ($_POST ?: []);

function val(array $v, string $k, $default = ''): string {
    return htmlspecialchars((string) ($v[$k] ?? $default));
}
?>
<div class="form-grid">
    <div class="form-group">
        <label for="cliente">Cliente</label>
        <input type="text" id="cliente" name="cliente" value="<?= val($v,'cliente') ?>" required placeholder="Nombre del cliente">
    </div>
    <div class="form-group">
        <label for="taxi">Placa / ID del Taxi</label>
        <input type="text" id="taxi" name="taxi" value="<?= val($v,'taxi') ?>" required placeholder="Ej: ABC-123">
    </div>
    <div class="form-group">
        <label for="taxista">Nombre del Taxista</label>
        <input type="text" id="taxista" name="taxista" value="<?= val($v,'taxista') ?>" required placeholder="Nombre del taxista">
    </div>
    <div class="form-group">
        <label for="cantidadPasajeros">Cantidad de Pasajeros (1-6)</label>
        <input type="number" id="cantidadPasajeros" name="cantidadPasajeros" value="<?= val($v,'cantidadPasajeros','1') ?>" min="1" max="6" required>
    </div>
    <div class="form-group">
        <label for="barrioInicio">Barrio de Inicio</label>
        <input type="text" id="barrioInicio" name="barrioInicio" value="<?= val($v,'barrioInicio') ?>" required placeholder="Barrio de origen">
    </div>
    <div class="form-group">
        <label for="barrioLlegada">Barrio de Llegada</label>
        <input type="text" id="barrioLlegada" name="barrioLlegada" value="<?= val($v,'barrioLlegada') ?>" required placeholder="Barrio de destino">
    </div>
    <div class="form-group">
        <label for="kilometros">Kilómetros Recorridos</label>
        <input type="number" id="kilometros" name="kilometros" value="<?= val($v,'kilometros','1') ?>" step="0.1" min="0.1" required>
    </div>
    <div class="form-group">
        <label for="duracionMinutos">Duración (minutos)</label>
        <input type="number" id="duracionMinutos" name="duracionMinutos" value="<?= val($v,'duracionMinutos','1') ?>" min="1" required>
    </div>
    <div class="form-group full">
        <label for="precio">Precio ($)</label>
        <input type="number" id="precio" name="precio" value="<?= val($v,'precio','0') ?>" step="0.01" min="0" required>
    </div>
</div>
