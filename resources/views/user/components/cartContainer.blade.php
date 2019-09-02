@auth
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12 main-section">
            <div class="dropdown-cart">
                @if (!empty(session('cart')))
                    <button type="button" class="btn btn-info" data-toggle="dropdown">
                        <span class="shopping-cart-img"></span>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger"><p>{{ count(session('cart')) }}</p></span>
                    </button>
                @else
                    <button type="button" class="btn btn-info" data-toggle="dropdown">
                        <span class="shopping-cart-img"></span>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger"><p>{{ '0' }}</p></span>
                    </button>
                @endif
                <div class="dropdown-cart-menu-noactive">
                    <div class="row total-header-section">
                        <div class="col-lg-6 col-sm-6 col-6">
                            @if (!empty(session('cart')))
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><p>{{ count(session('cart')) }}</p></span>
                            @else
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><p>{{ '0' }}</p></span>
                            @endif
                        </div>
                        @php $total = 0 @endphp
                        @if (!empty(session('cart')))
                            @foreach (session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                            @endforeach
                        @endif
                        @if (!empty(session('cart')))
                            @if ($clientPriviliges->client_priviliges === 'ADD_ORDER')
                                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                    <p>Total: <span class="text-info"><p>@if(!empty(session('cart'))){{ $sum }} @else {{ $total }} @endif zł</p></span></p>
                                </div>
                            @else
                                @if ($quantityProducts >= 3)
                                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                    <p>Total: <span class="text-info"><p>@if (!empty(session('cart'))) {{ $totalWithDiscount }} @else {{ $total }} @endif zł</p></span></p>
                                </div>
                                @else
                                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                    <p>Total: <span class="text-info"><p>@if (!empty(session('cart'))) {{ $sum }} @endif zł</p></span></p>
                                </div>
                                @endif
                            @endif
                        @endif
                    </div>
                    @if (!empty(session('cart')))
                        @foreach (session('cart') as $id => $details)
                            <div class="row cart-detail">
                                <div class="cart-detail-img">
                                    <img src="{!! url($details['image']) !!}"/>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    <span class="price text-info"><p>{{ $details['price'] . ' zł'}}</p></span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if (!empty(session('cart')))
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                <a href="" class="btn btn-primary btn-block"><p>View all</p></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endauth