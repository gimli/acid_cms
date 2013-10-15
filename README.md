raw_cms
=======

raw_cms

Welcome to Acid-Evo CMS systems repo!

this repo is only our development repo.
for main repo go to: https://github.com/gimli/cms

this repos holds our latest changes for the cms system.
all new feature will be tested out here before going public.

Acid-Evo CMS System.

an open-source cms system, free of charge.

more info to come.

whats working:
 * login/logout ( needs rewrite so u wont have to change password each time u change mail login ) / Nickless
 * 2 layer password encryption (current: md5(sha1($email,$password)) -> md5(sha1($acctid,$password))
 * session class ( will be loaded along whit the main engine -> SessionManager::sessionStart('username'); )
 * mysql class (Internal: $this->cms->Sql->query($sql) - External: $engine->Sql->query($sql) )
 * config class (Internal: $this->cms->Config->GetConfig('db_host') - External: $engine->Config->GetConfig('db_host') );
 * users class (...)
 * spyc class ( used to read yaml config (settings.yaml) )
 * some other stuff.

whats not working:
 * alot....

Install:
 * download: https://github.com/gimli/raw_cms/archive/master.zip
 * setup database in sql/
 * edit settings.yaml in includes/

Bug report:
 * https://github.com/gimli/raw_cms/issues
