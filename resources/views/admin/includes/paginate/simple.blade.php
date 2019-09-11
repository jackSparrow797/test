@if ($paginate->total() > $paginate->count())
    <div class="row">
        <div class="col-12">
            <div class="card my-3">
                <div class="card-body">
                    <nav aria-label="Page navigation example">
                        {{ $paginate->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif