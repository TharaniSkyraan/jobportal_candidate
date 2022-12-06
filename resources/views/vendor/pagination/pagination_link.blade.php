<div class="d-flex justify-content-center mt-5">
    {{ $datas->appends(request()->query())->links(); }}
</div>
