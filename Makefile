.PHONY: up server-is-up vm base provision halt destroy

###################
# Default locations
###################

PIDFILE=.vm/running.pid
BASE_IMAGE=.vm/base-image.qcow2
DEV_IMAGE=.vm/dev.qcow2

######################################################################
# Targets
######################################################################

# Provision
# =========

# Turn on (if needed) and provision the server

provision: up
	./deploy/scripts/provision.sh


# Spin up
# =======

up: $PIDFILE

# This is where we really turn it on
$PIDFILE: vm
	./deploy/scripts/run_vm.sh


# Create the base image
# =====================

base: $BASE_IMAGE

# This is where we really make the base image
$BASE_IMAGE:
	./ansible/scripts/make_base_image.sh


# Create the user's dev VM
# ========================

vm: $DEV_IMAGE

$DEV_IMAGE: base
	cp $BASE_IMAGE $DEV_IMAGE


# Turning stuff off and destroying
# ================================

halt:
	./deploy/scripts/halt_if_running.sh

destroy: halt
	-rm -f $DEV_IMAGE

destroy-base: halt
	-rm -f $BASE_IMAGE
