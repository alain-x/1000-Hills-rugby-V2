@if($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-1">Please check the following:</div>
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
