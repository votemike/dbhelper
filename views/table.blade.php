<h1>{{ $table->name }}</h1>
<ul>
    @foreach($table->getColumnsForDisplay() as $column)
        @if ($column->dataType != $column->getSuggestedType())
            <li><strong>{{ $column->name }}</strong> is <strong>{{ $column->dataType }}</strong> but should probably be
                <strong>{{ $column->getSuggestedType() }}</strong></li>
        @endif
    @endforeach
</ul>