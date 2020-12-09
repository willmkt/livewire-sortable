<!-- Modal Sector-->
<div wire:ignore.self  class="modal fade" id="sectorModal" tabindex="-1" role="dialog" aria-labelledby="compositionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($update == true)
                    <h5 class="modal-title" id="exampleModalLabel">Editar Setor</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Setor</h5>
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form wire:submit.prevent="create">

                    @if ($update == true)
                    <div class="form-group">
                        <label class="required" for="name">Name</label>
                        <input wire:model="sector_name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    </div>
                    @else
                        @if ($parent_name)
                            <H4><b> Setor: {{ $parent_name }}</b></H4>
                        @endif
            
                        <div class="form-group">
                            @if ($parent_name)
                                <label for="name">Parent name</label>
                            @else
                                <label class="required" for="name">Name</label>
                            @endif
                    
                            <input wire:model="sector_name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        </div>
                    @endif 
        
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>            
            
            </div>
        </div>
    </div>
</div>