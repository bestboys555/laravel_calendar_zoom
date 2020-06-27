<footer id="footer">
    <button class="icon-go-to-top float" style="display: block;"></button>
    <div class="inner-container">
        <div class="row">
            <div class="col-md-3">
                <div class="group-link no-sub  text-center">
                    @if($generalsetting->site_name != null)
                    <a href="{{ route('web.home') }}" title="{{ $generalsetting->site_name }}" class="logo">
                        <img src="{!! asset('images/logo_index.png') !!}" alt="{{ $generalsetting->site_name }}" style="width: 50px">
                    </a>
                    @endif
                    @if($generalsetting->phone != null)
                    <div class="list-links">
                        <a href="tel:{{ $generalsetting->phone }}" title="{{ $generalsetting->phone }}" class="call-center">{{ $generalsetting->phone }}</a>
                    </div>
                    @endif
                    @if($generalsetting->description != null)
                    <p class="mt-3">{{ $generalsetting->description }}</p>
                    @endif
                    <ul class="social-sharing">
                        @if($generalsetting->facebook != null)
                        <li><a href="{{ $generalsetting->facebook }}" title="Facebook" class="icon-facebook" target="_blank"></a></li>
                        @endif
                        @if($generalsetting->twitter != null)
                        <li><a href="{{ $generalsetting->twitter }}" title="Twitter" class="icon-twitter" target="_blank"></a></li>
                        @endif
                        @if($generalsetting->youtube != null)
                        <li><a href="{{ $generalsetting->youtube }}" title="YouTube" class="icon-youtube" target="_blank"></a></li>
                        @endif
                        @if($generalsetting->instagram != null)
                        <li><a href="{{ $generalsetting->instagram }}" title="Instagram" class="icon-instagram" target="_blank"></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p class="copy-right">©test</p>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">ออกจากระบบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                ต้องการออกจากระบบ ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <a type="button" class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                    ยืนยัน</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
