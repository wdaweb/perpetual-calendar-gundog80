# 建議事項
1. 主要檔案更名成index.php
2. 儘量使用相對路徑來取代絕對路徑
```
  href="./claender.php?showtime=....
    改成
  href="?showtime=....
```
3. `class=XXX`建議習慣加上雙引號或單引號`class="XXX"`，方便日後同時套用多個樣式時不會忘了加引號，比如`class="aaa bbb ccc"`
