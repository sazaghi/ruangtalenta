<form action="{{ route('interview.update', $interview->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Jadwal Interview</label>
        <input type="datetime-local" name="jadwal" value="{{ \Carbon\Carbon::parse($interview->jadwal)->format('Y-m-d\TH:i') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Link Interview</label>
        <input type="text" name="link" value="{{ $interview->link }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Metode</label>
        <input type="text" name="metode" value="{{ $interview->metode }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tipe</label>
        <input type="text" name="tipe" value="{{ $interview->tipe }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
