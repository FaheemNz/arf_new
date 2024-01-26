<form action="{{ route('asset.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <input type="hidden" name="asset" value="{{ $asset . 's' }}" />
    <button type="submit">Import</button>
</form>