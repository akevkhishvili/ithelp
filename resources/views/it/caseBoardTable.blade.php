<table style="font-size: 14px" class="table table-bordered table-hover table-sm">
    <thead>
    <tr>
        <th style="width:  10%">სტატუსი</th>
        <th style="width:  10%">თარიღი</th>
        <th style="width:  15%">გამომგზავნი</th>
        <th style="width:  15%">მიმაგრებულია</th>
        <th>ქეისის მიიღო</th>
        <th>ქეისის შინაარსი</th>
    </tr>
    </thead>
    @foreach($cases as $case)
        <tbody>
        <tr class="text-white
@if($case->status == 'აქტიური') bg-Red
@elseif($case->status == 'მიმაგრებულია') bg-BlueViolet
@elseif($case->status == 'მუშავდება') bg-DarkOrange
@elseif($case->status == 'გაუქმებული') d-none
@elseif($case->status == 'დახურული') d-none
@else bg-secondary  @endif"`>
            <td>{{$case->status}}</td>
            <td>{{$case->created_at}}</td>
            <td>{{$case->firstName}} {{$case->lastName}}</td>
            <td>{{$case->stacked_to}}</td>
            <td>{{$case->accepted_by}}</td>
            <td>{{$case->subject}}</td>
        </tr>
        </tbody>
    @endforeach
</table>
