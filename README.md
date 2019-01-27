# lcss
Light CSS pre processor

Just transform this :
```
@(#parent1) {

	@(.sub2.active) {

		body { color: #888; }

		@media print { body { color: #333; } }
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

#parent1 .sub2.active body {
 color: #888; 
}

@media print {
#parent1 .sub2.active body {
 color: #333; 
}


}

#parent1 code {
 color: blue; 
}

#parent .sous-style {

		display: none;
	
}

```