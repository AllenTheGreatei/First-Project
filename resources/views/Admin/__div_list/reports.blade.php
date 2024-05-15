<div class="report-container">
    <div class="header">
        <form action="{{route('download_report')}}" method="GET" style="width:100%;display: flex;flex-deriction:row; justify-content:space-between">
            <div class="head pt-3 pl-2">
                <h4 class="text-primary">Reports</h4>
            </div>
            <div class="filter row">
                <div class="col ">
                    <label class="fs-6 form-label pt-4">Filter Report :</label>
                </div>
                <div class="col">
                    <label class="form-label">from :</label>
                    <input type="date" class="form-control" name="from" id="from" required>
                </div>
                <div class="col">
                    <label class="form-label">to :</label>
                    <input type="date" class="form-control" name="end" id="end" required>
                </div>
            </div>
            <div class="download-container pt-3 pr-4">
                <button type="submit" class="btn btn-primary px-4" id="download-pdf">Download</button>
            </div>
        </form>
    </div>

    <div class="body">
        <table class = "user-list-table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Unit Charge (per/day) (₱)</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody id ="table_body" class="report_tbody">
                @php
                    $roomname ='';
                    $overall_total = 0;
                    $i =1;
                @endphp
                @foreach ($rooms as $room)
                    {{-- {{$roomname = $room->room_name}} --}}
                    @if ($room)
                        
                    @endif
                    <tr>
                        <th>{{$i++}}</th>
                        <th><img class="pr-3 rounded-2" style="height:4em;width:auto" src="{{asset('RoomImg/'.$room->image)}}">{{$room->room_name}}</th>
                        <th>{{$room->room_category}}</th>
                        <th>₱ {{ number_format($room->price)}}</th>
                        <th>₱ {{number_format($room->total_amount)}}</th>
                    </tr>
                    @php
                        $overall_total += $room->total_amount
                    @endphp
                   
                @endforeach
            </tbody>
        </table>
        <div class="foot mt-4">
            <label id="total_revenue" class="text-right form-label fs-6 pr-4">Total Revenue :  ₱ {{number_format($overall_total,2)}}</label>
        </div>
    </div>
</div>
<script src="{{ asset('new_js/content.js')}}"></script>