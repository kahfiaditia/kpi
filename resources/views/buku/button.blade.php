<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->id); ?>
<form class="delete-form" action="{{ route('buku.destroy', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-3">
        @if (in_array('70', $session_menu))
            <a href="{{ route('buku.show', $id) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
        @endif
        @if (in_array('72', $session_menu))
            <a href="{{ route('buku.edit', $id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
        @endif
        @if (in_array('73', $session_menu))
            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
        @endif
        <a href="{{ route('buku.print', $id) }}" class="text-dark"><i class="mdi mdi-printer font-size-18"></i></a>
    </div>
</form>
<script>
    $('.delete_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Data',
            text: 'Ingin menghapus data?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });
</script>
