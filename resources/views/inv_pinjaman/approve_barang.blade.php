<form action="{{ route('inv_pinjaman.approveProses', $id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Nama Barang <code>*</code></label>
                <input type="text" class="form-control" id="id_barang" name="judul" disabled
                    value="{{ $item->barang->nama }}" placeholder="Inventaris">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Diberikan<code>*</code></label>
                <div class="input-group" id="datepicker3">
                    <input type="text" class="form-control tgl_diberikan" placeholder="yyyy-mm-dd"
                        name="tgl_diberikan" id="tgl_diberikan" value="{{ date('Y-m-d') }}""
                        data-date-end-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                        data-date-container='#datepicker3' data-provide="datepicker" required
                        data-date-autoclose="true">
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    <div class="invalid-feedback">
                        Data wajib diisi.
                    </div>
                </div>
                {!! $errors->first('tgl_diberikan', '<div class="invalid-validasi">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="kondisi">Kondisi <code>*</code></label>
                <select name="kondisi" id="kondisi" class="form-control select select2 kondisi" required disabled>
                    <option value="{{ $item->barang->status }}">{{ $item->barang->status }} </option>

                </select>
                <div class="invalid-feedback">
                    Data wajib diisi.
                </div>
                {!! $errors->first('kondisi', '<div class="invalid-validasi">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="row" hidden>
        <input type="text" min="0" class="form-control number-only" id="id" name="id"
            value="" placeholder="id">

    </div>
    <div class="row modal-footer">
        <div class="col-sm-12">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" style="float: right" id="save">Simpan</button>
        </div>
    </div>
</form>
<script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/alert.js') }}"></script>
