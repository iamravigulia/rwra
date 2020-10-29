<div>
    <style>
        .fmt_box{
            margin: 10px 20px;
            padding: 10px 20px;
            border: 4px solid #eeeeee;
            background: #fff;
            box-shadow: 2px 4px 8px #b1b1b1;
        }
        .fmt_headline{
            font-size: 20px;
            margin:10px 0;
        }
        .fmt_label{
            font-size: 14px;
        }
        .fmt_input{
            padding:4px 10px;
            border:1px solid #707070;
            border-radius: 4px;
            display: block;
            font-size: 16px;
        }
        .fmt_sub_btn{
            padding:6px 20px;
            margin:10px 0;
            border-radius: 8px;
            background:#0047d4;
            color:#fff;
            border:none;
            letter-spacing: 1px;
            cursor: pointer;
        }
    </style>
    <form action="{{route('fmt.fillup.store')}}" method="post" class="fmt_box">
        <div class="fmt_headline">Add a Fill up Question</div>
        <div>
            <label class="fmt_label" for="">Question</label>
            <input class="fmt_input" type="text" name="question" placeholder="Question" required>
        </div>
        <hr>
        <div>
            <label class="fmt_label" for="">Answer 1</label>
            <input class="fmt_input" type="text" name="answer" placeholder="Answer" required>
        </div>
        <div>
            <input type="submit" class="fmt_sub_btn" value="Submit">
        </div>
    </form>
</div>