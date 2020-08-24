@extends('layouts.common')

@section('title', '学習リマインダートップ')


@section('content')
<div id="app">
 
 <div class="container">
  <div class="row justify-content-center">
   <h2 class="col-md-7">カテゴリー</h2>
   
 <!--モーダルボタン:新規作成-->
     <div class="col-md-2">
      <div class="js-modal-open" data-target="modal01">
       <button type="" class="btn-border"> +カテゴリー</button>
      </div>
     </div>
 <!--アーカイブ-->
  　<table class="table table-light rounded col-md-6">
   　 <thead class="text-muted">
   　  <tr>
   　    <th width=500>アーカイブ一覧</th>
 <!--アーカイブテーブルの中身をカウントして表示するコードを調べる-->
        <th width=200>10&ensp;<a href="{{ action('CategoryController@archive') }}"><i class="fas fa-angle-double-right text-muted"></i></a> </th>
   　    <th width=80></th>
        <th width=80></th>
   　  </tr>
   　</thead>
 
 <!--リマインダー関連-->
   　 <tbody>
   　  @foreach($items as $item)
 <!--id(hidden)@createから送信されたカテゴリー名をredirect→@topを通し、viewに表示するためにidが必要-->
  　  <input type="hidden" name="id" value="{{$item->id}}">
   　  
 <!--リマインダーカテゴリ一覧--> 
   　  <tr>
    　  <td width=500>{{ \Str::limit($item->name, 50)}}</td>
    　   <!--中身をカウントして表示するコードを後で入れる-->
       <td width=200>10&ensp;
        <a href="{{ action('CategoryController@remind',['id' => $item->id ,'name' => $item->name]) }}">
         <i class="fas fa-angle-double-right text-dark"></i>
        </a>
       </td>
       
 <!--モーダルボタン：リマインダーカテゴリ編集-->
       <td width=80>
        <a href="" class="js-modal-open" data-target="modal02">
          <i class="far fa-edit text-dark"></i>
        </a>
       </td>
       
 <!--モーダルボタン：リマインダーカテゴリ消去-->
       <td width=80>
        <a class="js-modal-open" href="" data-target="modal03">
         <i class="far fa-trash-alt text-dark"></i>
         </a>
       </td>
       
   　  </tr>
   　@endforeach
   　</tbody> 
    </table>
 
   </div>
  </div>
 
 <!--モーダル新規作成-->
 <div id="modal01" class="modal js-modal">
  
  <div class="modal__bg js-modal-close"></div>
  
  <div class="modal__content">
   <p>新規カテゴリー作成</p>
   
    <form name="addcategory" action="{{ action('CategoryController@create') }}" method="post" enctype="multipart/form-data">
    @if (count($errors) > 0)
     <ul>
       @foreach($errors->all() as $e)
         <li>{{ $e }}</li>
       @endforeach
     </ul>
    @endif
    
    <div class="form-group">
     <input type="text" class="form-control" name="name" value="{{ old('name')}}">
    </div>
   
    {{ csrf_field() }}
    {{--<button type="submit" class="js-modal-close btn-border">作成</button>--}}
    <button type="submit" class="btn-border">作成</button>
   </form>
  </div>
  
 </div>
  
  
 <!--モーダルカテゴリ名編集-->
 <div id="modal02" class="modal js-modal">
  
  <div class="modal__bg js-modal-close"></div>
  
  <div class="modal__content">
   <p>カテゴリー名編集</p>
   
   <form name="updatecategory" action="{{ action('CategoryController@update') }}" method="post" enctype="multipart/form-data">
  <!--以下を入力すると、新規作成でエラーがあった場合、関係ない変種のモーダルにもエラー文が反映されてしまう-->
    <!--@if (count($errors) > 0)-->
    <!-- <ul>-->
    <!--   @foreach($errors->all() as $e)-->
    <!--     <li>{{ $e }}</li>-->
    <!--   @endforeach-->
    <!-- </ul>-->
    <!--@endif-->
    
     <div class="form-group">
      <input type="text" class="form-control" name="name" value="{{ old('name')}}">
     </div>
    
    {{ csrf_field() }}
    <button type="submit" class="btn-border">変更</bottun>
   </form>
  </div>
  
 </div>
 
 <!--モーダル消去ボタン-->
 <div id="modal03" class="modal js-modal">
  
  <div class="modal__bg js-modal-close"></div>
  
  <div class="modal__content">
   
     <input type="hidden" name="id" value="">
     <p>『○○』を消去しますか？</p>
     
     <button type="submit" class="js-modal-close btn btn-danger">消去</bottun>
  </div>
  
 </div>

</div>
@endsection

@section('js')
@php
if (Session::has('modal')) {
  $modal = session('modal');
} else {
  $modal = null;
}
@endphp
<script>
  window.onload = function() {
    @if(isset($modal))
      var target = '{{$modal}}';
      console.log('enter onload');
      console.log(target);
      if (target != null && target != '') {
        var modal = document.getElementById(target);
        $(modal).fadeIn();
      }
    @endif
    return false;
}
</script>
@endsection
