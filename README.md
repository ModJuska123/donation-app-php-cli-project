# donation-app-php-cli-project

This is a simple PHP CLI APP designed to track donations, enables log donations to specific charities. 
Project is developed for educational purposes only.

## 📑 Table of Contents
- Installation
- Running the APP
- Use commands in VSC terminal
- Authors
- License


## 🚀Installation
To get started:

1. Open the folder to clone the APP:

```powershell
cd YourFoldersName
```

2. Clone the APP: 

```powershell
git clone git clone https://github.com/ModJuska123/donation-app-php-cli-project
```

3. Run a XAMPP server (Apache and Mysql).

4. Create a 'fundraiser' DB with tables 'charities' and 'donations'.

5. Create a csv file with columns: name;email.

## 🎉Running the APP

1. Open the APP you just cloned.
2. Run the APP entering `php index.php` into the terminal.


## 🧪Use commands in VSC terminal

1. To view list of charities:
     ```powershell
     php index.php --controller=Charity --method=charitiesList
     ```
2. To add a new charity:
     ```powershell
     php index.php --controller=Charity --method=create --name=CharityName --email=Charity@email.com
     ```
3. To edit a charity:
     ```powershell
     php index.php --controller=Charity --method=update --id=CharityId --name=NewCharity --email=newCharity@gmail.com
     ```
4. To delete a charity:
     ```powershell
     php index.php --controller=Charity --method=delete --id=CharityId
     ```
5. To add a donation to a charity:
     ```powershell
     php index.php --controller=Donation --method=add --charityId=CharityId --name=YourName --amount=donationAmount --dateTime=DateAndTimeOfDonation
     ```
6. To add charities from a CSV file:
     ```powershell
     php index.php --controller=Csv --method=upload --filepath=Filepath
     ```

## 🎓 Authors

Modestas Juška: [Github](https://github.com/ModJuska123).

## 🎭 License

Distributed under the MIT license.
