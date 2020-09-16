<?php

class ContactView 
{
	public function printContact(string $code): void
	{
		print_r("Contact: ");
		print_r("Code: " . $code);
	}
}
