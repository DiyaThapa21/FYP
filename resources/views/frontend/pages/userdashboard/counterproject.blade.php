@extends('frontend.layouts.master')

@section('title', 'Un-ko Uneko || User Dashboard')

@section('main-content')
<style>
    .counter-btn {
        cursor: pointer;
        font-size: 20px;
        border: 1px solid #ccc;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .counter-value {
        font-size: 20px;
        display: inline-block;
        width: 40px;
        text-align: center;
        padding: 5px 10px;
        margin: 0 10px;
    }
</style>
<div class="container mt-3 mb-3">
    <div class="card shadow-sm p-4 rounded-lg">
        <div class="row">

            @include('frontend.pages.userdashboard.include.sidebar')

            <div class="col-md-9">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card card-margin">
                                <form action="{{route('counterincrement.store')}}" method="POST">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="project_name">Project Name</label>
                                            <input type="text" class="form-control" id="project_name"
                                                placeholder="Enter Project Name">
                                        </div>


                                        <div class="d-flex align-items-center">
                                            <button class="counter-btn" id="decrement">-</button>
                                            <div class="counter-value" id="counterValue">0</div>
                                            <button class="counter-btn" id="increment">+</button>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-4">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let counter = 0;

    // Get the elements
    const counterValue = document.getElementById('counterValue');
    const incrementBtn = document.getElementById('increment');
    const decrementBtn = document.getElementById('decrement');

    // Add event listeners for increment and decrement buttons
    incrementBtn.addEventListener('click', () => {
        counter++;
        counterValue.textContent = counter;
    });

    decrementBtn.addEventListener('click', () => {
        if (counter > 0) {
            counter--;
            counterValue.textContent = counter;
        }
    });
</script>

@endsection