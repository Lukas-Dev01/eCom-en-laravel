@extends('master')
@section('content')
@php
  $countries = [
    'United States' => '+1',
    'Canada' => '+1',
    'United Kingdom' => '+44',
    'Ireland' => '+353',
    'Lithuania' => '+370',
    'Latvia' => '+371',
    'Estonia' => '+372',
    'Ukraine' => '+380',
    'Poland' => '+48',
    'Germany' => '+49',
    'France' => '+33',
    'Spain' => '+34',
    'Italy' => '+39',
    'Netherlands' => '+31',
    'Belgium' => '+32',
    'Sweden' => '+46',
    'Norway' => '+47',
    'Denmark' => '+45',
    'Finland' => '+358',
    'Portugal' => '+351',
    'Greece' => '+30',
    'Czech Republic' => '+420',
    'Slovakia' => '+421',
    'Hungary' => '+36',
    'Romania' => '+40',
    'Bulgaria' => '+359',
    'Austria' => '+43',
    'Switzerland' => '+41',
    'Australia' => '+61',
    'New Zealand' => '+64',
    'Japan' => '+81',
    'South Korea' => '+82',
    'China' => '+86',
    'India' => '+91',
    'Singapore' => '+65',
    'United Arab Emirates' => '+971',
    'Turkey' => '+90',
    'Brazil' => '+55',
    'Mexico' => '+52',
    'South Africa' => '+27',
  ];
  $selectedCountry = old('country', 'United States');
@endphp
<main class="account-page">
  <section class="account-shell">
    <div class="account-hero">
      <span class="home-kicker">Saved addresses</span>
      <h1>Delivery addresses.</h1>
      <p>Add delivery locations for checkout, then show them as clean address cards in the account area.</p>
    </div>

    <div class="address-layout">
      <form class="account-panel address-form" action="/addresses" method="POST" data-address-form>
        @csrf
        <input type="hidden" name="address_id" value="" data-address-id>
        <div class="address-form-header">
          <h3 data-address-form-title>Add address</h3>
          @if(session('address_saved'))
          <span>{{ session('address_saved') }}</span>
          @endif
        </div>

        <div class="address-form-grid">
          <label>
            Address label
            <input class="form-control" name="label" value="{{ old('label', 'Home') }}" placeholder="Home, Work, Parents" required>
            @error('label')<small>{{ $message }}</small>@enderror
          </label>

          <label>
            Street address
            <input class="form-control" name="street" value="{{ old('street') }}" placeholder="123 Main Street" required>
            @error('street')<small>{{ $message }}</small>@enderror
          </label>

          <label>
            Apartment
            <input class="form-control" name="apartment" value="{{ old('apartment') }}" placeholder="Apt 4B">
            @error('apartment')<small>{{ $message }}</small>@enderror
          </label>

          <label>
            City
            <input class="form-control" name="city" value="{{ old('city') }}" placeholder="New York" required>
            @error('city')<small>{{ $message }}</small>@enderror
          </label>

          <label>
            Postal code
            <input class="form-control" name="postal_code" value="{{ old('postal_code') }}" placeholder="10001" required>
            @error('postal_code')<small>{{ $message }}</small>@enderror
          </label>

          <label>
            Country
            <select class="form-control" name="country" data-country-select required>
              @foreach($countries as $country => $phoneCode)
              <option value="{{ $country }}" data-phone-code="{{ $phoneCode }}" {{ $selectedCountry === $country ? 'selected' : '' }}>
                {{ $country }} ({{ $phoneCode }})
              </option>
              @endforeach
            </select>
            @error('country')<small>{{ $message }}</small>@enderror
          </label>

          <label class="address-form-wide">
            Phone
            <input class="form-control" name="phone" value="{{ old('phone', $countries[$selectedCountry] ?? '+1') }}" placeholder="+1 555 123 4567" data-phone-input>
            @error('phone')<small>{{ $message }}</small>@enderror
          </label>
        </div>

        <div class="address-form-actions">
          <button class="btn btn-dark" type="submit" data-address-submit>Save address</button>
          <button class="btn btn-outline-secondary d-none" type="button" data-address-cancel>Cancel edit</button>
        </div>
      </form>

      <div class="address-grid">
        @if(count($addresses) > 0)
        @foreach($addresses as $address)
        <article class="account-panel address-card">
          <span class="address-label">{{ $loop->first ? 'Default' : $address['label'] }}</span>
          <h3>{{ $address['name'] }}</h3>
          <p>
            {{ $address['street'] }}
            @if($address['apartment'])
            <br>{{ $address['apartment'] }}
            @endif
            @if($address['city'] || $address['postal_code'])
            <br>{{ $address['city'] }} {{ $address['postal_code'] }}
            @endif
            @if($address['country'])
            <br>{{ $address['country'] }}
            @endif
          </p>
          @if($address['phone'])
          <strong>{{ $address['phone'] }}</strong>
          @endif
          @if(($address['source'] ?? '') === 'saved')
          <div class="address-card-actions">
            <button
              class="btn btn-outline-secondary btn-sm"
              type="button"
              data-edit-address
              data-id="{{ $address['id'] }}"
              data-label="{{ $address['label'] }}"
              data-street="{{ $address['street'] }}"
              data-apartment="{{ $address['apartment'] }}"
              data-city="{{ $address['city'] }}"
              data-postal-code="{{ $address['postal_code'] }}"
              data-country="{{ $address['country'] }}"
              data-phone="{{ $address['phone'] }}"
            >Edit</button>
            <form action="/addresses/delete" method="POST">
              @csrf
              <input type="hidden" name="address_id" value="{{ $address['id'] }}">
              <button class="btn btn-outline-danger btn-sm" type="submit">Remove</button>
            </form>
          </div>
          @endif
        </article>
        @endforeach
        @else
        <article class="account-panel address-card">
          <span class="address-label">Empty</span>
          <h3>No addresses yet</h3>
          <p>Add a street address, city, postal code, and country using the form.</p>
        </article>
        @endif
      </div>
    </div>
  </section>
</main>
@endsection
