<form method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label>Select Image File:</label>
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>
