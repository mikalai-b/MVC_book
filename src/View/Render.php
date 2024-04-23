<?php

namespace View;

use Entity\AddressesBook;

class Render
{
    public function renderList(array $records): string
    {
        $row = '';
        /** @var AddressesBook $record */
        foreach ($records as $record) {
            $row = $row .
                '
                <tr>
                    <td>' . $record->getName() . '</td>
                    <td>' . $record->getSurname() . '</td>
                    <td>' . $record->getPhone() . '</td>
                    <td>' . $record->getEmail() . '</td>
                    <td style="white-space: pre-line;">' . $record->getAddress() . '</td>
                    <td><a href="update?id=' . $record->getId() . '">Update</a></td>
                    <td><a href="delete?id=' . $record->getId() . '">Delete</a></td>
                </tr>
                ';

        }
        return '
    <head><style>body {font-family: sans-serif;} table, th, td {border: 1px solid black; border-collapse: collapse;} th, td {padding: 1rem;}</style></head>
    <h2><a href="/">Address Book</a></h2>
    <table>
        <tr><th>Name</th><th>Surname</th><th>Phone</th><th>Email</th><th>Address</th><th colspan="2">Actions</th></tr>'
        . $row .
    '</table>
        ';
    }

    public function renderHomepage(): string
    {
        return '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <style>
                    body {
                        font-family: sans-serif;
                    }
                </style>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Address Book App</title>
            </head>
            <body>
            <h1>Address Book App</h1>
            <ul>
                <li><a href="/list">View Records</a></li>
                <li><a href="/add">Add Record</a></li>
            </ul>
            </body>
            </html>
        ';
    }

    public function renderAddForm()
    {
        return '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <style>
                    body {
                        font-family: sans-serif;
                    }
                    input, button, textarea {
                        padding: 0.5rem 1rem;
                    }
                </style>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Address Book</title>
            </head>
            <body>
            <h2><a href="/">Add Record</a></h2>
            <form action="/add" method="POST">
                <div style="display: grid; grid-template-columns: auto 1fr; gap: 1rem; align-items: center; max-width: 600px;">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" required>
                
                    <label for="phone">
                        Phone:<br />
                        <small>Format: 123-456-789</small>
                    </label>
                    <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" id="phone" name="phone">
                
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                
                    <label for="address">Address:</label>
                    <textarea id="address" name="address"></textarea>
                
                    <button type="submit">Add record</button>
                </div>
            </form>
            </body>
            </html>
        ';
    }

    public function renderUpdateForm(AddressesBook $record): string
    {
        return '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <style>
                    body {
                        font-family: sans-serif;
                    }
                    input, button, textarea {
                        padding: 0.5rem 1rem;
                    }
                </style>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update Record</title>
            </head>
            <body>
                <h2><a href="/">Update Record</a></h2>
                <form action="/update?id=' . $record->getId() . '" method="POST">
                    <div style="display: grid; grid-template-columns: auto 1fr; gap: 1rem; align-items: center; max-width: 600px;">
                        <input type="hidden" name="id" value="' . $record->getId() . '">
                        <label for="name">Name:</label> <input type="text" name="name" required value="' . $record->getName() . '">
                        <label for="surname">Surname:</label> <input type="text" name="surname" required value="' . $record->getSurname() . '">
                        <label for="phone">Phone:<br /><small>Format: 123-456-789</small></label> <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" value="' . $record->getPhone() . '">
                        <label for="email">Email:</label> <input type="email" name="email" value="' . $record->getEmail() . '">
                        <label for="address">Address:</label> <textarea name="address">' . $record->getAddress() . '</textarea>
                        <button type="submit">Update</button>
                    </div>
                </form>
        ';
    }
}
