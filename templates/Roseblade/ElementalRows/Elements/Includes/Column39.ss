<% if $FullWidth %><div class="container-fluid"><% else %><div class="container"><% end_if %>
	<div class="row {$RowClass}">
		<div class="col-md-3 {$ColumnClass} {$ColumnClass1} <% if $AddSpacingToBottom %>mb-4<% end_if %>">
			{$ElementalArea1}
		</div>
		<div class="col-md-9 {$ColumnClass} {$ColumnClass2} <% if $AddSpacingToBottom %>mb-4<% end_if %>">
			{$ElementalArea2}
		</div>
	</div>
</div>