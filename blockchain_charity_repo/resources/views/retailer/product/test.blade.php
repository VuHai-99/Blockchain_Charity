<form action="{{route('admin.test')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file[]" id="" multiple>
    <input type="submit" value="submit">
</form>