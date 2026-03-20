<?php

declare(strict_types=1);

/**
 * Example: Hashing and verifying passwords with Password_Hash in CE Phoenix.
 *
 * Password_Hash implements the phpass portable password hashing framework.
 * Phoenix uses it to create and verify customer passwords stored in the DB.
 *
 * Modern PHP uses password_hash()/password_verify(), but this class remains
 * for backward compatibility with existing hashes in the customers table.
 */

require_once __DIR__ . '/../includes/classes/password_hash.php';

// 1. Create a hasher.
//    - First argument: iteration count log2 (8 = 256 iterations, range 4–31).
//    - Second argument: portable_hashes. False = use bcrypt when available (recommended).
$hasher = new Password_Hash(8, false);

// 2. Hash a new password (e.g. during customer registration)
$plaintext  = 'super$ecret123';
$storedHash = $hasher->hash_password($plaintext);

echo "Stored hash: {$storedHash}\n";
// Stored hash: $2a$10$... (bcrypt, 60 chars) or $P$... (phpass, 34 chars)

// 3. Verify a password on login
$inputPassword = 'super$ecret123';
if ($hasher->check_password($inputPassword, $storedHash)) {
    echo "Password matches — login successful.\n";
} else {
    echo "Password does not match.\n";
}

// 4. Wrong password attempt
if (!$hasher->check_password('wrongpass', $storedHash)) {
    echo "Incorrect password — login denied.\n";
}
