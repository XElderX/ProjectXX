<!-- Modal -->
<div class="modal fade" id="deleteSurname{{ $surname->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Surname Deletation from the pool comfirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are your sure to delete this surname?
            </div>
            <div class="modal-footer">
                <button type="button" class="button" data-bs-dismiss="modal">Close</button>
                <button type="button" class="button"><a
                        href="{{ route('surname.delete', [$surname->id]) }}">Delete</a></button>
            </div>
        </div>
    </div>
</div>