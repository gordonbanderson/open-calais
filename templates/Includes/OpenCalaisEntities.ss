<h2>Open Calais Entities</h2>
<ul class="tagCloud">
<% loop GroupedEntities.List %>
<li>$Name
<ul>
<% loop Entities %>
<li>$Value</li>
<% end_loop %>
</ul>
</li>
<% end_loop %>
</ul>
<hr/>
