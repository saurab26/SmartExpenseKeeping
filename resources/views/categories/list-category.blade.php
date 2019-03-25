<div class="col-sm-6">
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name (No. of Budgets)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @if(count($categories)>0)
                
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->name}} ({{$category->budgets}})</td>
                    <td>
                        <a href="{{ route('category.edit',$category->id)}}"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('category.delete',$category->id)}}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>           
    </div>
</div>