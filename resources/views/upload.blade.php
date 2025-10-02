<form action="{{ route('image.upload', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">رفع الصورة</button>
</form>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    <img src="{{ session('image_url') }}" alt="الصورة المرفوعة" width="200">
@endif
