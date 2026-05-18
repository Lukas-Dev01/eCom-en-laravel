@extends('master')
@section("content")
@php
  $statusLabels = [
    'pending' => 'Pending',
    'processing' => 'Processing',
    'shipped' => 'Shipped',
    'delivered' => 'Delivered',
    'cancelled' => 'Cancelled',
  ];

  $statusMessages = [
    'pending' => [
      'title' => 'Waiting for confirmation',
      'body' => 'Your order is saved. We will keep it here until it is confirmed or cancelled.',
    ],
    'processing' => [
      'title' => 'Being prepared',
      'body' => 'Your order has been confirmed and is being prepared for delivery.',
    ],
    'shipped' => [
      'title' => 'On the way',
      'body' => 'Your order has left the store and is moving through delivery.',
    ],
    'delivered' => [
      'title' => 'Delivered',
      'body' => 'This order has been completed and moved into your order history.',
    ],
    'cancelled' => [
      'title' => 'Cancelled',
      'body' => 'This order was cancelled and is kept here for reference.',
    ],
  ];
@endphp
<div class="custom-product">
  <div class="orders-page">
    <div class="cart-header">
      <div>
        <span class="product-category">Orders</span>
        <h3>My orders</h3>
        <p class="orders-intro">Track active orders and keep cancelled orders separate from the current queue.</p>
      </div>
    </div>

    @if(session('success'))
    <div class="page-alert page-alert-success" role="status">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="page-alert page-alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <section class="orders-section" aria-labelledby="active-orders-title">
      <div class="orders-section-header">
        <h4 id="active-orders-title">Active orders</h4>
        <span>{{ count($activeOrders) }} active</span>
      </div>

      @if(count($activeOrders) > 0)
      <div class="orders-list">
        @foreach($activeOrders as $item)
        @php
          $status = strtolower(trim($item->status ?? 'pending'));
          $statusClass = preg_replace('/[^a-z0-9-]+/', '-', $status) ?: 'pending';
          $statusLabel = $statusLabels[$status] ?? \Illuminate\Support\Str::headline($status);
          $statusMessage = $statusMessages[$status] ?? null;
        @endphp
        <div class="order-card">
          <a class="order-card-image" href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
            <img src="{{ \App\Models\Product::imageUrl($item->gallery) }}" alt="{{$item->name}}">
          </a>

          <div class="order-card-info">
            <span class="order-status-pill order-status-{{ $statusClass }}">{{ $statusLabel }}</span>
            <a href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
              <h4>{{$item->name}}</h4>
            </a>
            <p class="order-address">{{$item->address}}</p>
            <div class="order-meta">
              @if(!empty($item->order_date))
              <span><strong>Placed</strong> {{ \Carbon\Carbon::parse($item->order_date)->format('M j, Y') }}</span>
              @endif
              <span><strong>Payment</strong> {{ ucfirst($item->payment_status) }}</span>
              <span><strong>Method</strong> {{ ucfirst($item->payment_method) }}</span>
            </div>
            @if($statusMessage)
            <div class="order-status-callout order-status-callout-{{ $statusClass }}">
              <span class="order-status-dot" aria-hidden="true"></span>
              <div>
                <strong>{{ $statusMessage['title'] }}</strong>
                <small>{{ $statusMessage['body'] }}</small>
              </div>
            </div>
            @endif
          </div>

          <div class="order-actions">
            @if($status === 'pending')
            <button class="btn btn-outline-danger" type="button" data-cancel-order="{{$item->order_id}}" data-order-name="{{$item->name}}">Cancel order</button>
            @else
            <span class="order-status-note">Order {{ strtolower($statusLabel) }}</span>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="empty-state">
        <h4>No active orders</h4>
        <p>New orders will show here while they are still in progress.</p>
      </div>
      @endif
    </section>

    <section class="orders-section" aria-labelledby="history-orders-title">
      <div class="orders-section-header">
        <h4 id="history-orders-title">Order history</h4>
        <span>{{ count($orderHistory) }} completed or cancelled</span>
      </div>

      @if(count($orderHistory) > 0)
      <div class="orders-list">
        @foreach($orderHistory as $item)
        @php
          $status = strtolower(trim($item->status ?? 'pending'));
          $statusClass = preg_replace('/[^a-z0-9-]+/', '-', $status) ?: 'pending';
          $statusLabel = $statusLabels[$status] ?? \Illuminate\Support\Str::headline($status);
          $statusMessage = $statusMessages[$status] ?? null;
        @endphp
        <div class="order-card order-card-muted">
          <a class="order-card-image" href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
            <img src="{{ \App\Models\Product::imageUrl($item->gallery) }}" alt="{{$item->name}}">
          </a>

          <div class="order-card-info">
            <span class="order-status-pill order-status-{{ $statusClass }}">{{ $statusLabel }}</span>
            <a href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
              <h4>{{$item->name}}</h4>
            </a>
            <p class="order-address">{{$item->address}}</p>
            <div class="order-meta">
              @if(!empty($item->order_date))
              <span><strong>Placed</strong> {{ \Carbon\Carbon::parse($item->order_date)->format('M j, Y') }}</span>
              @endif
              <span><strong>Payment</strong> {{ ucfirst($item->payment_status) }}</span>
              <span><strong>Method</strong> {{ ucfirst($item->payment_method) }}</span>
              @if($item->cancel_reason)
              <span class="order-meta-wide"><strong>Reason</strong> {{$item->cancel_reason}}</span>
              @endif
            </div>
            @if($statusMessage)
            <div class="order-status-callout order-status-callout-{{ $statusClass }}">
              <span class="order-status-dot" aria-hidden="true"></span>
              <div>
                <strong>{{ $statusMessage['title'] }}</strong>
                <small>{{ $statusMessage['body'] }}</small>
              </div>
            </div>
            @endif
          </div>

          <div class="order-actions">
            @if($status === 'cancelled')
            <form action="/deleteorder" method="POST">
              @csrf
              <input type="hidden" name="order_id" value="{{$item->order_id}}">
              <button class="btn btn-outline-secondary" type="submit">Delete from history</button>
            </form>
            @else
            <span class="order-status-note">Order {{ strtolower($statusLabel) }}</span>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="empty-state">
        <h4>No order history yet</h4>
        <p>Delivered and cancelled orders will move here automatically.</p>
      </div>
      @endif
    </section>

    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content cancel-order-modal">
          <form action="/cancelorder" method="POST">
            @csrf
            <input type="hidden" name="order_id" id="cancel_order_id">

            <div class="modal-header">
              <div>
                <h5 class="modal-title" id="cancelOrderTitle">Cancel order</h5>
                <p id="cancel_order_name">Tell us why you want to cancel this order.</p>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="cancel-modal-field">
                <label for="cancel_email">Account email</label>
                <input class="form-control" type="email" id="cancel_email" name="cancel_email" value="{{ Session::get('user')['email'] ?? '' }}" readonly required>
              </div>

              <div class="cancel-modal-field">
                <label for="cancel_reason_group">Reason group</label>
                <select class="form-select" id="cancel_reason_group" name="cancel_reason_group" required>
                  <option value="" selected disabled>Select a reason</option>
                  <option value="Changed my mind">Changed my mind</option>
                  <option value="Ordered by mistake">Ordered by mistake</option>
                  <option value="Found a better price">Found a better price</option>
                  <option value="Delivery takes too long">Delivery takes too long</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="cancel-modal-field">
                <label for="cancel_reason_details">Your reason</label>
                <textarea class="form-control" id="cancel_reason_details" name="cancel_reason_details" rows="4" placeholder="Write a short reason for cancellation" maxlength="255" required></textarea>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keep order</button>
              <button type="submit" class="btn btn-danger">Confirm cancellation</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
