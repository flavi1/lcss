# lcss
Light CSS pre processor

Just transform this :
```
@(#parent1) {
  @(.sub1.myClass > span, .sub2.active) {
    body { color: #888; }
    @media print {
      body { color: #333; }
    }
  }
  @(.sub3) {
    code { color: red; }
  }
  code { color: blue; }
}

@(#parent) {
  .sous-style {
    display: none;
  }
}
```

To this :

```
#parent1 .sub1.myClass > span body, #parent1  .sub2.active body {
 color: #888; 
}

@media print {
#parent1 .sub1.myClass > span body, #parent1  .sub2.active body {
 color: #333; 
}


}

#parent1 .sub3 code {
 color: red; 
}

#parent1 code {
 color: blue; 
}

#parent .sous-style {

    display: none;
  
}

```

TODO :
======

* parse imported files (@import) adding parent selectors
* Remove or keep comments ?
* Two modes. With indentation to help debugging, and integrated minification

That's all folks!
Do you realy need more?
