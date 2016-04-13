<h1>{{ $table->name }}</h1>
<ul>
    @foreach($table->getColumnsForDisplay() as $column)
        @if ($column->dataType != $column->getSuggestedType())
            <li>
                <strong>{{ $column->name }}</strong> is
                @if($column->isNumeric())
                    <strong>{{ $column->dataType }} ({{ $column->isSigned() ? 'signed' : 'unsigned' }})</strong> but should probably be <strong>{{ $column->getSuggestedType() }} ({{ $column->shouldBeUnsigned() ? 'unsigned' : 'signed' }})</strong>
                @else
                    <strong>{{ $column->dataType }}</strong> but should probably be <strong>{{ $column->getSuggestedType() }}</strong>
                @endif
            </li>
        @endif
    @endforeach
</ul>