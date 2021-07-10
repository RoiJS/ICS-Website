@if(Request::is('student/profile') == false)
    @if(Request::is('teacher/profile') == false)
        <div class='app-back-drop'>
            <div>
                <div class="app-loader"></div>
                <label class="loading-message">Loading&hellip;</label>	
            </div>
        </div>
    @endif
@endif
