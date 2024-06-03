<div style="max-height: 350px; overflow-y: auto;">
    @if($alertas->isEmpty())
    <p>No tienes alertas</p>
    @else
    @foreach($alertas as $alerta)
        <div wire:key="alerta-{{ $alerta->id }}" style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px 10px 5px 10px; display: flex; justify-content: space-between; align-items: center;">
            <div >
                <h3>{{ $alerta->titulo }}</h3>
                <p style=" margin-bottom:0;">{{ $alerta->descripcion }}</p>
                <button type="button" class="btn btn-primary mt-2" wire:click.stop="accion({{ $alerta->id }})">Aceptar</button>
            </div>
        </div>
    @endforeach
    @endif
</div>
