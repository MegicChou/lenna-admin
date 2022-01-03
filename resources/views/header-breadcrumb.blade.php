<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach($breadcrumb as $item)
                    <?php
                        $cssName = 'breadcrumb-item';
                        if ($item->active) {
                            $cssName .= ' active';
                        }
                    ?>
                    <li class="{{ $cssName }}"><a href="{{ $item->url }}">{{ $item->name }}</a></li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
