<div class="col-sm-6">
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($periods)>0)
                @foreach($periods as $period)
                <tr>
                    <td>{{ App\Providers\Common::format_date($period->from)}}</td>
                    <td>{{App\Providers\Common::format_date($period->to)}}</td>
                    <td>
                        <a href="{{ route('period.edit',$period->id)}}"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('period.delete',$period->id)}}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>                
    </div>
</div>