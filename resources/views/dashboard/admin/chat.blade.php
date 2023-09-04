@extends('dashboard.admin.master')
@section('title', 'Report | Chat')
@include('dashboard.admin.css')
<link rel="stylesheet" href="{{ asset('assets/css/chatapp.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>Dashboard
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li> 
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>                           
                    <li class="breadcrumb-item active">Chat</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                @if(Session::get('errorMsg'))
                    <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                @endif
                @if(Session::get('successMsg'))
                    <span class="text-success">{{ Session::get('successMsg') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @foreach ($users as $user)
                            <li class="clearfix userData" data-id="{{ $user->id }}">
                                <img src="{{ asset('images/users/'.$user->profile_picture) }}" alt="{{ $user->full_name }}" />
                                <div class="about">
                                    <div class="name">{{ $user->full_name }}</div>
                                    <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="chat" id="chatBox">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6 headerInfo">
                                <a href="javascript:void(0);">
                                    <img src="http://127.0.0.1:8000/images/users/1685859973_avatar6.jpg" alt="avatar" />
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0">Aiden Chavez</h6>
                                    <small>Last seen: 2 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history">
                        <ul class="m-b-0">
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time" >10:10 AM, Today</span>
                                    <img src="http://127.0.0.1:8000/images/users/1685859973_avatar6.jpg" alt="avatar">
                                </div>
                                <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <form id="messageSender">
                            @csrf
                            <div class="input-group mb-0">
                                <input type="text" class="form-control" placeholder="Enter text here..." id="message" name="message" required>
                                <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}" id="senderId">
                                <input type="hidden" name="receiver_id" value="" id="receiverId">
                                <div class="input-group-prepend">
                                    <button type="submit" id="submit" class="input-group-text">
                                        <i class="icon-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include("dashboard.admin.script")
<script>
    const userItems = document.querySelectorAll('.userData');
    const chatBoxEle = document.getElementById('chatBox');
    const loggedInUserId = parseInt('{{ Auth::user()->id }}');

    
// Add click event listener to each user item
// userItems.forEach(function(userItem) {
//     userItem.addEventListener('click', function(event) {
//         event.preventDefault();

//         // Get the user's ID from the data attribute
//         const userId = userItem.dataset.id;

//         // Update the chat header with the selected user's information
//         const chatHeader = document.querySelector('.chat-header');
//         const userName = userItem.querySelector('.name').textContent;
//         const userImage = userItem.querySelector('img').src;
//         chatHeader.querySelector('h6').textContent = userName;
//         chatHeader.querySelector('img').src = userImage;
        

//         // Set the receiver_id input value to the selected user's ID
//         document.getElementById('receiverId').value = userId;

//         // Fetch and display the messages for the selected user
//         fetchMessages(userId);
//     });
// });




// Function to fetch and display the messages for a specific user
function fetchMessages(userId) {
    // Send AJAX request to retrieve the messages
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/chat/get-messages?receiver_id=' + userId, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Success! Handle the response here
                const messages = JSON.parse(xhr.responseText);
                updateChatHistory(messages);
            } else {
                // Error occurred
                console.error('An error occurred.');
            }
        }
    };

    xhr.send();
}
    

    document.getElementById('messageSender').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    const form = document.getElementById('messageSender');
    const formData = new FormData(form);

    // Send AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route('send') }}', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Success! Handle the response here
                const messages = JSON.parse(xhr.responseText);
                updateChatHistory(messages);
                document.getElementById('message').value = '';
            } else {
                // Error occurred
                console.error('An error occurred.');
            }
        }
    };

    xhr.send(formData);
});


// Function to update the chat history with the messages

function updateChatHistory(messages) {
  const chatHistory = document.querySelector('.chat-history ul');
  chatHistory.innerHTML = '';

  messages.forEach(function(message) {
    const li = document.createElement('li');
    li.className = 'clearfix';

    const messageData = document.createElement('div');
    messageData.className = message.sender_id === loggedInUserId ? 'message-data text-right' : 'message-data';

    const messageDataTime = document.createElement('span');
    messageDataTime.className = 'message-data-time';
    messageDataTime.textContent = message.created_at;

    const img = document.createElement('img');
    img.src = '{{ asset('images/users/') }}/' + (message.sender_id === loggedInUserId ? '{{ Auth::user()->profile_picture }}' : message.other_user_profile_picture);
    img.alt = 'avatar';

    const messageContent = document.createElement('div');
    messageContent.className = message.sender_id === loggedInUserId ? 'message my-message float-right' : 'message other-message';
    messageContent.textContent = message.message;

    if (message.sender_id === loggedInUserId) {
      messageData.appendChild(messageDataTime);
      messageData.appendChild(img);
      li.appendChild(messageData);
      li.appendChild(messageContent);
    } else {
      li.appendChild(messageDataTime);
      li.appendChild(messageData);
      li.appendChild(messageContent);
    }

    chatHistory.appendChild(li);
  });
}


function updateChatHistory(messages) {
  const chatHistory = document.querySelector('.chat-history ul');
  chatHistory.innerHTML = '';

  messages.forEach(function(message) {
    const li = document.createElement('li');
    li.className = 'clearfix';

    const messageData = document.createElement('div');
    messageData.className = message.sender_id === loggedInUserId ? 'message-data text-right' : 'message-data';

    const img = document.createElement('img');
    img.src = '{{ asset('images/users/') }}/' + (message.sender_id === loggedInUserId ? '{{ Auth::user()->profile_picture }}' : message.other_user_profile_picture);
    img.alt = 'avatar';

    const messageContent = document.createElement('div');
    messageContent.className = message.sender_id === loggedInUserId ? 'message my-message float-right' : 'message other-message';
    messageContent.textContent = message.message;

    const messageDataTime = document.createElement('span');
    messageDataTime.className = 'message-data-time';
    messageDataTime.textContent = formatMessageTime(message.created_at);

    if (message.sender_id === loggedInUserId) {
      messageData.appendChild(messageDataTime);
      messageData.appendChild(img);
      li.appendChild(messageData);
      li.appendChild(messageContent);
    } else {
      messageData.appendChild(messageDataTime);
      li.appendChild(messageData);
      li.appendChild(messageContent);
    }

    chatHistory.appendChild(li);
  });
}


function formatMessageTime(dateTime) {
  const messageDate = new Date(dateTime);
  const currentDate = new Date();

  const options = {
    hour: 'numeric',
    minute: 'numeric',
    hour12: true
  };

  if (messageDate.toDateString() === currentDate.toDateString()) {
    return 'Today ' + messageDate.toLocaleTimeString('en-US', options);
  } else if (messageDate.toDateString() === currentDate.setDate(currentDate.getDate() - 1).toDateString()) {
    return 'Yesterday ' + messageDate.toLocaleTimeString('en-US', options);
  } else if (messageDate.getMonth() === currentDate.getMonth()) {
    return messageDate.getDate() + ' ' + messageDate.toLocaleTimeString('en-US', options);
  } else {
    return messageDate.toLocaleString('en-US', { month: 'short' }) + ' ' + messageDate.getDate();
  }
}



</script>
@endsection
